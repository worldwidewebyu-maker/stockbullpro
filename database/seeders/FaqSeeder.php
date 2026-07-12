<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is Bull Pro?',
                'answer'   => 'Bull Pro is an advanced online trading platform that allows individuals to invest in a wide range of financial instruments including stocks, ETFs, cryptocurrencies, forex, and more. Our platform is designed to be accessible to both beginners and experienced traders worldwide.',
            ],
            [
                'question' => 'What are the requirements to become a member?',
                'answer'   => 'To become a member of Bull Pro, you must be at least 18 years old, provide a valid email address, and complete our simple identity verification process. We accept members from over 176 countries worldwide.',
            ],
            [
                'question' => 'What is the minimum deposit amount?',
                'answer'   => 'The minimum deposit amount varies depending on your chosen payment method and account type. Please log in or contact our support team for specific details on minimum deposit requirements for your region and preferred payment method.',
            ],
            [
                'question' => 'How do I withdraw my profits?',
                'answer'   => 'You can withdraw your profits at any time through your account dashboard. We support multiple withdrawal methods including bank transfer, cryptocurrency, and e-wallets. Withdrawal requests are typically processed within 24-48 hours.',
            ],
            [
                'question' => 'What trading instruments are available?',
                'answer'   => 'Bull Pro offers trading in stocks, ETFs, cryptocurrencies, forex currency pairs, commodities, and market indices. Our multi-asset platform gives you access to thousands of trading instruments from global markets all in one place.',
            ],
            [
                'question' => 'Is my investment safe with Bull Pro?',
                'answer'   => 'We take the security of your investments very seriously. All client funds are held in segregated accounts, we use bank-grade encryption, and our platform complies with strict financial regulations. However, please note that all trading involves risk and past performance is not indicative of future results.',
            ],
            [
                'question' => 'Are there any fees or commissions?',
                'answer'   => 'Bull Pro offers competitive fee structures. Fees may vary depending on the asset class, account type, and transaction volume. Please refer to our fee schedule in your account dashboard for detailed information on all applicable charges.',
            ],
            [
                'question' => 'How do I contact customer support?',
                'answer'   => 'Our customer support team is available 24/7. You can reach us via email at info@stockbullpro.com, through the live chat feature on our platform, or by submitting a message through the contact form on this page. We aim to respond within a few hours.',
            ],
        ];

        foreach ($faqs as $i => $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                ['answer' => $faq['answer'], 'is_active' => true, 'sort_order' => $i + 1]
            );
        }
    }
}
