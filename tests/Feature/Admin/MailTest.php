<?php

namespace Tests\Feature\Admin;

use App\Models\Customer;
use App\Notifications\AdminBroadcastMail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MailTest extends TestCase
{
    public function test_admin_can_send_email_to_all_users(): void
    {
        Notification::fake();

        $admin = $this->createAdmin();
        $this->createUser(['email' => 'user1@test.com']);
        $this->createUser(['email' => 'user2@test.com']);

        $response = $this->actingAs($admin)->post(route('admin.mail.send'), [
            'subject'        => 'Platform Update',
            'message'        => 'Hello everyone',
            'recipient_type' => 'all',
        ]);

        $response->assertRedirect(route('admin.mail.create'));
        $response->assertSessionHas('success');

        Notification::assertSentTimes(AdminBroadcastMail::class, 2);
    }

    public function test_admin_can_send_email_to_selected_users(): void
    {
        Notification::fake();

        $admin = $this->createAdmin();
        $user1 = $this->createUser();
        $user2 = $this->createUser();

        $response = $this->actingAs($admin)->post(route('admin.mail.send'), [
            'subject'        => 'Personal note',
            'message'        => 'Just for you',
            'recipient_type' => 'selected',
            'user_ids'       => [$user1->id],
        ]);

        $response->assertSessionHas('success');
        Notification::assertSentTo(Customer::find($user1->id), AdminBroadcastMail::class);
        Notification::assertNotSentTo(Customer::find($user2->id), AdminBroadcastMail::class);
    }
}
