<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\DepositLog;
use App\Notifications\DepositApproved;
use App\Notifications\DepositRejected;
use Illuminate\Http\Request;

class DepositLogController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $deposits = DepositLog::with(['user', 'method'])
            ->when(in_array($status, ['pending', 'approved', 'rejected']), fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $counts = [
            'pending'  => DepositLog::where('status', 'pending')->count(),
            'approved' => DepositLog::where('status', 'approved')->count(),
            'rejected' => DepositLog::where('status', 'rejected')->count(),
        ];

        return view('admin.deposits.index', compact('deposits', 'status', 'counts'));
    }

    public function approve(Request $request, DepositLog $deposit)
    {
        if ($deposit->status !== 'pending') {
            return back()->with('error', 'This deposit has already been processed.');
        }

        $deposit->approve($request->user());

        $user = $deposit->user->fresh();
        $user->notify(new DepositApproved((float) $deposit->amount, (float) $user->balance));

        AdminActivityLog::create([
            'admin_id'       => $request->user()->id,
            'action'         => 'approve_deposit',
            'target_user_id' => $deposit->user_id,
            'description'    => 'Approved deposit #' . $deposit->id . ' ($' . number_format($deposit->amount, 2) . ')',
            'meta'           => ['deposit_id' => $deposit->id, 'amount' => (float) $deposit->amount],
        ]);

        return back()->with('success', 'Deposit approved and user credited.');
    }

    public function reject(Request $request, DepositLog $deposit)
    {
        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:255'],
        ]);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'This deposit has already been processed.');
        }

        $deposit->reject($request->user(), $validated['admin_note'] ?? null);

        $deposit->user->notify(new DepositRejected((float) $deposit->amount, $validated['admin_note'] ?? null));

        AdminActivityLog::create([
            'admin_id'       => $request->user()->id,
            'action'         => 'reject_deposit',
            'target_user_id' => $deposit->user_id,
            'description'    => 'Rejected deposit #' . $deposit->id,
            'meta'           => ['deposit_id' => $deposit->id, 'note' => $validated['admin_note'] ?? null],
        ]);

        return back()->with('success', 'Deposit rejected.');
    }
}
