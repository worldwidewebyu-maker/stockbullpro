<?php

namespace Tests\Feature\Admin;

use App\Models\Faq;
use Tests\TestCase;

class FaqTest extends TestCase
{
    public function test_admin_can_create_faq(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post(route('admin.faqs.store'), [
            'question'   => 'What is Bull Pro?',
            'answer'     => 'An investment platform.',
            'sort_order' => 1,
            'is_active'  => '1',
        ]);

        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseHas('faqs', ['question' => 'What is Bull Pro?']);
    }

    public function test_admin_can_update_faq(): void
    {
        $admin = $this->createAdmin();
        $faq   = Faq::create([
            'question'   => 'Old question?',
            'answer'     => 'Old answer.',
            'sort_order' => 1,
            'is_active'  => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.faqs.update', $faq), [
            'question'   => 'New question?',
            'answer'     => 'New answer.',
            'sort_order' => 2,
            'is_active'  => '1',
        ]);

        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseHas('faqs', ['id' => $faq->id, 'question' => 'New question?']);
    }

    public function test_admin_can_delete_faq(): void
    {
        $admin = $this->createAdmin();
        $faq   = Faq::create([
            'question'   => 'Delete me?',
            'answer'     => 'Gone.',
            'sort_order' => 1,
            'is_active'  => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.faqs.destroy', $faq));

        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }
}
