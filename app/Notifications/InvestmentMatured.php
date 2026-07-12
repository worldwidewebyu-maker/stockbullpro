<?php

namespace App\Notifications;

use App\Models\UserInvestment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvestmentMatured extends Notification
{
    use Queueable;

    public function __construct(
        public UserInvestment $investment,
        public float $principal,
        public float $profit,
        public float $totalPayout,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your investment plan has matured')
            ->greeting('Hello ' . ($notifiable->full_name ?: $notifiable->username) . ',')
            ->line("Your investment in {$this->investment->plan_name} has reached maturity.")
            ->line('Principal returned: $' . number_format($this->principal, 2))
            ->line('Profit paid: $' . number_format($this->profit, 2))
            ->line('Total credited to your balance: $' . number_format($this->totalPayout, 2))
            ->action('View Dashboard', route('dashboard.index'))
            ->line('Thank you for investing with Bull Pro.');
    }
}
