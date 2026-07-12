<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Customer;
use App\Notifications\AdminBroadcastMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class MailController extends Controller
{
    public function create()
    {
        $users = Customer::orderBy('username')->get(['id', 'username', 'full_name', 'email']);

        return view('admin.mail.create', compact('users'));
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'subject'        => ['required', 'string', 'max:255'],
            'message'        => ['required', 'string', 'max:10000'],
            'recipient_type' => ['required', 'in:all,selected'],
            'user_ids'       => ['required_if:recipient_type,selected', 'array'],
            'user_ids.*'     => ['integer', 'exists:users,id'],
        ]);

        $recipients = $data['recipient_type'] === 'all'
            ? Customer::all()
            : Customer::whereIn('id', $data['user_ids'] ?? [])->get();

        if ($recipients->isEmpty()) {
            return back()->withInput()->with('error', 'No recipients selected.');
        }

        Notification::send(
            $recipients,
            new AdminBroadcastMail($data['subject'], $data['message'])
        );

        AdminActivityLog::create([
            'admin_id'    => $request->user()->id,
            'action'      => 'send_broadcast_mail',
            'description' => 'Sent "' . $data['subject'] . '" to ' . $recipients->count() . ' user(s)',
        ]);

        return redirect()->route('admin.mail.create')
            ->with('success', 'Email sent to ' . $recipients->count() . ' user(s).');
    }
}
