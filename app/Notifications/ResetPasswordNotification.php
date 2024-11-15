<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    protected $token;
    protected $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('http://localhost:5173/reset-password') . '?token=' . $this->token . '&email=' . urlencode($this->email);

        return (new MailMessage)
            ->subject('Redefinição de Senha')
            ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.')
            ->action('Redefinir Senha', $url)
            ->line('Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.')
            ->line('Este link de redefinição de senha expira em 60 minutos.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
