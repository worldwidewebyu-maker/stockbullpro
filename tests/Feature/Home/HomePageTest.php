<?php

namespace Tests\Feature\Home;

use App\Models\Faq;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_displays_active_faqs(): void
    {
        Faq::create([
            'question'   => 'Visible question?',
            'answer'     => 'Visible answer.',
            'sort_order' => 1,
            'is_active'  => true,
        ]);

        Faq::create([
            'question'   => 'Hidden question?',
            'answer'     => 'Hidden answer.',
            'sort_order' => 2,
            'is_active'  => false,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Visible question?');
        $response->assertSee('Visible answer.');
        $response->assertDontSee('Hidden question?');
    }
}
