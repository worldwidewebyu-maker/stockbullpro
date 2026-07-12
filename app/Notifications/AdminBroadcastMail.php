<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminBroadcastMail extends Notification
{
    use Queueable;

    public function __construct(
        public string $mailSubject,
        public string $mailBody,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject($this->mailSubject)
            ->greeting('Hello ' . ($notifiable->full_name ?: $notifiable->username) . ',');

        foreach (preg_split('/\r\n|\r|\n/', trim($this->mailBody)) as $line) {
            if ($line !== '') {
                $mail->line($line);
            }
        }

        return $mail
            ->action('Go to Dashboard', route('dashboard.index'))
            ->line('Thank you for being part of Bull Pro.');
    }
}
