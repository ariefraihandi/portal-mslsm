<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $name;
    protected $url;
    protected $encryptedParams;

    public function __construct($name, $url, $encryptedParams)
    {
        $this->name = $name;
        $this->url = $url;
        $this->encryptedParams = $encryptedParams;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->url . '?verify=' . $this->encryptedParams;

        return (new MailMessage)
                    ->subject('Verify Your Email Address')
                    ->greeting('Hello, ' . $this->name)
                    ->line('Please click the button below to verify your email address.')
                    ->action('Verify Email', $verificationUrl)
                    ->line('If you did not create an account, no further action is required.');
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
