<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function start(Request $request, Customer $user)
    {
        $admin = $request->user();

        if ($user->isAdmin()) {
            return back()->with('error', 'You cannot impersonate another admin.');
        }

        AdminActivityLog::create([
            'admin_id'       => $admin->id,
            'action'         => 'impersonate_start',
            'target_user_id' => $user->id,
            'description'    => 'Started impersonating ' . $user->username,
        ]);

        $request->session()->put('impersonator_id', $admin->id);
        Auth::login($user);

        return redirect()->route('dashboard.index');
    }

    public function stop(Request $request)
    {
        $impersonatorId = $request->session()->pull('impersonator_id');

        if (! $impersonatorId) {
            return redirect()->route('dashboard.index');
        }

        $admin = User::find($impersonatorId);

        if (! $admin || ! $admin->isAdmin()) {
            Auth::logout();
            return redirect()->route('admin.login');
        }

        $impersonatedId = Auth::id();
        Auth::login($admin);

        AdminActivityLog::create([
            'admin_id'       => $admin->id,
            'action'         => 'impersonate_stop',
            'target_user_id' => $impersonatedId,
            'description'    => 'Stopped impersonating',
        ]);

        return redirect()->route('admin.users.show', $impersonatedId);
    }
}
