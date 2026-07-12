<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use App\Models\WithdrawalMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $methods = WithdrawalMethod::active()->get();

        // Build a keyed map: method_id => wallet_address for the blade
        $wallets = $user->wallets()->pluck('wallet_address', 'withdrawal_method_id');

        return view('dashboard.profile', compact('user', 'methods', 'wallets'));
    }

    public function updatePersonal(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'phone'     => ['required', 'string', 'max:30'],
            'country'   => ['required', 'string', 'size:2'],
            'username'  => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username,' . $user->id],
        ]);

        $user->update($data);

        return back()->with('success_tab', 'personal')->with('success', 'Personal information updated successfully.');
    }

    public function updateWallets(Request $request)
    {
        $user    = auth()->user();
        $methods = WithdrawalMethod::active()->get();

        // Build dynamic validation rules
        $rules = [];
        foreach ($methods as $method) {
            $rules['wallet_' . $method->id] = ['nullable', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);

        foreach ($methods as $method) {
            $address = $validated['wallet_' . $method->id] ?? null;

            if ($address) {
                UserWallet::updateOrCreate(
                    ['user_id' => $user->id, 'withdrawal_method_id' => $method->id],
                    ['wallet_address' => $address]
                );
            } else {
                UserWallet::where('user_id', $user->id)
                    ->where('withdrawal_method_id', $method->id)
                    ->delete();
            }
        }

        return back()->with('success_tab', 'wallets')->with('success', 'Withdrawal wallet addresses saved.');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The old password is incorrect.'])
                         ->with('active_tab', 'password');
        }

        $user->update(['password' => $request->password]);

        return back()->with('success_tab', 'password')->with('success', 'Password updated successfully.');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'notify_withdrawal_otp'    => ['required', 'in:0,1'],
            'notify_profit_email'      => ['required', 'in:0,1'],
            'notify_plan_expiry_email' => ['required', 'in:0,1'],
        ]);

        auth()->user()->update([
            'notify_withdrawal_otp'    => (bool) $request->notify_withdrawal_otp,
            'notify_profit_email'      => (bool) $request->notify_profit_email,
            'notify_plan_expiry_email' => (bool) $request->notify_plan_expiry_email,
        ]);

        return back()->with('success_tab', 'settings')->with('success', 'Notification settings saved.');
    }
}
