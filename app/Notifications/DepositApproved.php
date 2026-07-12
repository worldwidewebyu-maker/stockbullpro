<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DepositApproved extends Notification
{
    use Queueable;

    public function __construct(
        public float $amount,
        public float $newBalance,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your deposit has been approved')
            ->greeting('Hello ' . ($notifiable->full_name ?: $notifiable->username) . ',')
            ->line('Your deposit of $' . number_format($this->amount, 2) . ' has been approved and credited to your account.')
            ->line('Your new account balance is $' . number_format($this->newBalance, 2) . '.')
            ->action('Go to Dashboard', route('dashboard.index'))
            ->line('Thank you for choosing Bull Pro.');
    }
}
