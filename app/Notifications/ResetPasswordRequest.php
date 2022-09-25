<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
class ResetPasswordRequest extends Notification
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
  
     public function toMail($notifiable)
     {
        $url = route('admin.reset-password-new',['token'=>$this->token]);
        return (new MailMessage)
            ->subject('Quản trị viên - Quên mật khẩu')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', url($url))
            ->line('If you did not request a password reset, no further action is required.');
    }
}