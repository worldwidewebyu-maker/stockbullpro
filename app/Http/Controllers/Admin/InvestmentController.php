<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserInvestment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('q');

        $investments = UserInvestment::with('user')
            ->when(in_array($status, ['active', 'matured', 'cancelled']), fn ($q) => $q->where('status', $status))
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total_invested'  => (float) UserInvestment::sum('amount'),
            'active_count'    => UserInvestment::where('status', 'active')->count(),
            'active_amount'   => (float) UserInvestment::where('status', 'active')->sum('amount'),
            'matured_count'   => UserInvestment::where('status', 'matured')->count(),
        ];

        $counts = [
            'active'    => $stats['active_count'],
            'matured'   => $stats['matured_count'],
            'cancelled' => UserInvestment::where('status', 'cancelled')->count(),
        ];

        return view('admin.investments.index', compact('investments', 'status', 'search', 'stats', 'counts'));
    }
}
