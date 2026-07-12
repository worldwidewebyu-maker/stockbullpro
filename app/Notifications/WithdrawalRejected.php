<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalRejected extends Notification
{
    use Queueable;

    public function __construct(
        public float $amount,
        public float $newBalance,
        public ?string $reason = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Your withdrawal was declined')
            ->greeting('Hello ' . ($notifiable->full_name ?: $notifiable->username) . ',')
            ->line('Your withdrawal request of $' . number_format($this->amount, 2) . ' was declined and the amount has been refunded to your balance.')
            ->line('Your available balance is now $' . number_format($this->newBalance, 2) . '.');

        if ($this->reason) {
            $mail->line('Reason: ' . $this->reason);
        }

        return $mail
            ->action('Go to Dashboard', route('dashboard.index'))
            ->line('If you have questions, please contact support.');
    }
}
