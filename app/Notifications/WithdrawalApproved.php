<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalApproved extends Notification
{
    use Queueable;

    public function __construct(
        public float $amount,
        public float $finalAmount,
        public ?string $walletAddress = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Your withdrawal has been approved')
            ->greeting('Hello ' . ($notifiable->full_name ?: $notifiable->username) . ',')
            ->line('Your withdrawal request of $' . number_format($this->amount, 2) . ' has been approved.')
            ->line('Amount sent: $' . number_format($this->finalAmount, 2) . '.');

        if ($this->walletAddress) {
            $mail->line('Destination: ' . $this->walletAddress);
        }

        return $mail
            ->action('Go to Dashboard', route('dashboard.index'))
            ->line('Thank you for choosing Bull Pro.');
    }
}
