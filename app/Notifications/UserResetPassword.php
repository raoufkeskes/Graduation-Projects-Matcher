<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @param $token
     */
    public function __construct($token)
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
        $type = lcfirst($notifiable->userable_type) ;
        
        return (new MailMessage)
            ->subject('Changement de mot de passe ')
            ->greeting('Cher Utilisateur,')
            ->line('Vous venez de recevoir ce message car on vient de recevoir une demande de modification du mot de passe de votre compte .')
            ->action('Changer mon mot de passe', url($type.'/password/reset', $this->token))
            ->line('Dans le cas ou vous n\'êtes pas celui qui a envoyé cette demande  aucune autre action est nécessaire')
            ->salutation('Cordialement') ;
    }
}
