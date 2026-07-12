<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected array $types = [
        'deposit', 'withdrawal', 'investment',
        'profit', 'referral_bonus', 'bonus', 'adjustment', 'transfer',
    ];

    public function index(Request $request)
    {
        $type      = $request->query('type');
        $direction = $request->query('direction');
        $search    = $request->query('q');

        $transactions = Transaction::with('user')
            ->when(in_array($type, $this->types), fn ($q) => $q->where('type', $type))
            ->when(in_array($direction, ['credit', 'debit']), fn ($q) => $q->where('direction', $direction))
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(30)
            ->withQueryString();

        $totals = [
            'credits' => (float) Transaction::where('direction', 'credit')->sum('amount'),
            'debits'  => (float) Transaction::where('direction', 'debit')->sum('amount'),
            'count'   => Transaction::count(),
        ];

        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'types'        => $this->types,
            'type'         => $type,
            'direction'    => $direction,
            'search'       => $search,
            'totals'       => $totals,
        ]);
    }
}
