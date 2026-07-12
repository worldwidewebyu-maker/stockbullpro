<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountDebited extends Notification
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
            ->subject('Your account has been debited')
            ->greeting('Hello ' . ($notifiable->full_name ?: $notifiable->username) . ',')
            ->line('An amount of $' . number_format($this->amount, 2) . ' has been deducted from your Bull Pro account by an administrator.')
            ->line('Your new account balance is $' . number_format($this->newBalance, 2) . '.');

        if ($this->note) {
            $mail->line('Note: ' . $this->note);
        }

        return $mail
            ->action('Go to Dashboard', route('dashboard.index'))
            ->line('If you have questions, please contact support.');
    }
}
