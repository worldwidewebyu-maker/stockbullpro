<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'email_verification_enabled' => Setting::isEmailVerificationEnabled(),
            'whatsapp_number'            => Setting::get('whatsapp_number', Setting::DEFAULT_WHATSAPP_NUMBER),
            'support_email'              => Setting::get('support_email', 'info@finbullstock.com'),
            'referral_max_deposits'      => (int) Setting::get('referral_max_deposits', 3),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'email_verification_enabled' => ['nullable', 'boolean'],
            'whatsapp_number'          => ['nullable', 'string', 'max:30'],
            'support_email'              => ['required', 'email', 'max:255'],
            'referral_max_deposits'      => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        Setting::set('email_verification_enabled', $request->boolean('email_verification_enabled') ? '1' : '0');
        Setting::set('whatsapp_number', $data['whatsapp_number'] ?: Setting::DEFAULT_WHATSAPP_NUMBER);
        Setting::set('whatsapp_link', '');
        Setting::set('support_email', $data['support_email']);
        Setting::set('referral_max_deposits', (string) $data['referral_max_deposits']);

        AdminActivityLog::create([
            'admin_id'    => $request->user()->id,
            'action'      => 'update_settings',
            'description' => 'Updated general platform settings',
        ]);

        return back()->with('success', 'Settings saved successfully.');
    }
}
