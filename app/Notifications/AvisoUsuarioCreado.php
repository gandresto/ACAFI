<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AvisoUsuarioCreado extends Notification
{
    use Queueable;

    protected $extraData;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($extraData)
    {
        $this->extraData = $extraData;
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
        return (new MailMessage)
                    ->subject('Aviso de registro de usuario')
                    ->greeting("¡Saludos, {$notifiable->gradoNombreCompleto}!")
                    ->line('Has sido registrado como usario en el sistema de '
                    .'agenda para las academias de la FI. Tus datos para iniciar sesión son:')
                    ->line("- **Correo:** {$notifiable->email}")
                    ->line("- **Contraseña:** {$this->extraData['rawPass']}")
                    ->action('Haz click aquí para iniciar sesión', url('/login'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
