<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordFrontend extends Notification
{
    use Queueable;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('customer.reset-password-new',['token'=>$this->token]);
        return (new MailMessage)
            ->subject('Quên mật khẩu')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', url($url))
            ->line('If you did not request a password reset, no further action is required.');
    }

 
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
