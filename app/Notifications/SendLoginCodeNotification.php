<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendLoginCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $plainOtp,
        public string $magicLink,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your ShareSpace login code')
            ->markdown('emails.login-code', [
                'otp' => $this->plainOtp,
                'magicLink' => $this->magicLink,
            ]);
    }
}
