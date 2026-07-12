<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Transfer;
use App\Models\User;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransferController extends Controller
{
    public function index()
    {
        $chargePercentage = (float) Setting::get('transfer_charge_percentage', 0);

        return view('dashboard.transfer', compact('chargePercentage'));
    }

    public function submit(Request $request, WalletService $wallet)
    {
        $request->validate([
            'recipient' => ['required', 'string', 'max:255'],
            'amount'    => ['required', 'numeric', 'min:0.01'],
        ]);

        $sender = $request->user();
        $amount = round((float) $request->amount, 2);

        $recipient = User::where('id', '!=', $sender->id)
            ->where(function ($q) use ($request) {
                $q->where('email', $request->recipient)
                    ->orWhere('username', $request->recipient);
            })
            ->first();

        if (! $recipient) {
            throw ValidationException::withMessages([
                'recipient' => 'No user found with that email or username.',
            ]);
        }

        $chargePercentage = (float) Setting::get('transfer_charge_percentage', 0);
        $charge = round($amount * $chargePercentage / 100, 2);
        $total  = $amount + $charge;

        if ($total > (float) $sender->balance) {
            throw ValidationException::withMessages([
                'amount' => 'Insufficient balance. Your available balance is $' . number_format($sender->balance, 2) . '.',
            ]);
        }

        DB::transaction(function () use ($sender, $recipient, $amount, $charge, $total, $wallet) {
            $transfer = Transfer::create([
                'sender_id'    => $sender->id,
                'recipient_id' => $recipient->id,
                'amount'       => $amount,
                'charge'       => $charge,
                'total'        => $total,
                'status'       => 'completed',
            ]);

            $wallet->debit($sender, $total, 'transfer', $transfer, "Transfer to {$recipient->username}");
            $wallet->credit($recipient, $amount, 'transfer', $transfer, "Transfer from {$sender->username}");
        });

        return redirect()->route('dashboard.transfer')
            ->with('success', 'Transfer of $' . number_format($amount, 2) . ' to ' . $recipient->username . ' was successful.');
    }
}
