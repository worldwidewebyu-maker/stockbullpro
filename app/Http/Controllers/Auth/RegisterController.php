<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username'  => ['required', 'string', 'max:50', 'unique:users,username', 'regex:/^\S+$/'],
            'full_name' => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'     => ['required', 'string', 'max:30'],
            'country'   => ['required', 'string', 'size:2'],
            'referral'  => ['nullable', 'string', 'max:50'],
            'password'  => ['required', 'confirmed', Password::min(8)],
        ]);

        $referrer = null;
        if ($request->filled('referral')) {
            $referrer = User::where('referral_code', $request->referral)
                ->orWhere('username', $request->referral)
                ->first();
        }

        $user = User::create([
            'username'    => $request->username,
            'full_name'   => $request->full_name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'country'     => $request->country,
            'referral'    => $request->referral,
            'referred_by' => $referrer?->id,
            'password'    => Hash::make($request->password),
        ]);

        if (Setting::isEmailVerificationEnabled()) {
            event(new Registered($user));
        } else {
            $user->markEmailAsVerified();
        }

        Auth::login($user);

        return redirect()->route(
            Setting::isEmailVerificationEnabled() ? 'verification.notice' : 'dashboard.index'
        );
    }
}
