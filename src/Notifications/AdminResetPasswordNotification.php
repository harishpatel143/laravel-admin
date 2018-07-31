<?php

namespace Multidots\Admin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordNotification extends Notification
{

    use Queueable;

    //Token handler
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token = null)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
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
        $link = url("/admin/account/password/reset/token=" . $this->token);

        return ( new MailMessage)
                        ->from('multidots@example.com')
                        ->subject('Reset your password')
                        ->line("You are receiving this email because we received a password reset request for your account. ")
                        ->action('Reset Password', $link)
                        ->line('If you did not request a password reset, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
