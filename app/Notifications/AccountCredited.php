<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountCredited extends Notification
{
    use Queueable;

    public function __construct(
        public float $amount,
        public float $newBalance,
        public ?string $note = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Your account has been credited')
            ->greeting('Hello ' . ($notifiable->full_name ?: $notifiable->username) . ',')
            ->line('Your Bull Pro account has been credited with $' . number_format($this->amount, 2) . '.')
            ->line('Your new account balance is $' . number_format($this->newBalance, 2) . '.');

        if ($this->note) {
            $mail->line('Note: ' . $this->note);
        }

        return $mail
            ->action('Go to Dashboard', route('dashboard.index'))
            ->line('Thank you for choosing Bull Pro.');
    }
}
