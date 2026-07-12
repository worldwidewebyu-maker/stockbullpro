<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DepositRejected extends Notification
{
    use Queueable;

    public function __construct(
        public float $amount,
        public ?string $reason = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Your deposit was declined')
            ->greeting('Hello ' . ($notifiable->full_name ?: $notifiable->username) . ',')
            ->line('Your deposit of $' . number_format($this->amount, 2) . ' could not be approved.');

        if ($this->reason) {
            $mail->line('Reason: ' . $this->reason);
        }

        return $mail
            ->action('Contact Support', route('dashboard.deposit'))
            ->line('If you believe this is an error, please contact support.');
    }
}
