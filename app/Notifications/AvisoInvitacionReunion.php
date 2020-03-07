<?php

namespace App\Notifications;

use App\Reunion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AvisoInvitacionReunion extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reunion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reunion $reunion)
    {
        $this->reunion = $reunion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $usuarioNotificado
     * @return array
     */
    public function via($usuarioNotificado)
    {
        $preferencias = [];
        if($usuarioNotificado->prefiere_email) array_push($preferencias, 'mail');
        if($usuarioNotificado->prefiere_notificaciones_app) array_push($preferencias, 'database');
        return  ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $usuarioNotificado
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($usuarioNotificado)
    {
        $link_reunion = route('reuniones.show', $this->reunion->id);
        $link_ordendeldia = route('reuniones.ordendeldia.descargar', $this->reunion->id);
        return (new MailMessage)
                    ->subject("Invitación a Reunión")
                    ->greeting("Hola, {$usuarioNotificado->gradoNombreCompleto}.")
                    ->line("Fuiste convocado la reunión que se celebrará el día "
                    . "**" . formato_dia_y_fecha_esp($this->reunion->inicio) . "**"
                    // . "**" . $this->reunion->inicio->locale('es')->format('l\, d \d\e F \d\e Y') . "**"
                    // . "**" . $this->reunion->inicio->formatLocalized('%A, %d de %B de %Y') . "**"
                    . " por parte de la Academia de {$this->reunion->academia->nombre}"
                    . " de la {$this->reunion->academia->departamento->division->nombre}.")
                    ->line("- **Lugar:** {$this->reunion->lugar}")
                    ->line("- **Hora de inicio:** " . $this->reunion->inicio->format('h:i A'))
                    ->line("- **Hora de finalización:** " . $this->reunion->fin->format('h:i A'))
                    ->action("Descargar orden del día", $link_ordendeldia)
                    ->line("Para más detalles, consulta el siguiente link: [{$link_reunion}]({$link_reunion}).");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $usuarioNotificado
     * @return array
     */
    public function toArray($usuarioNotificado)
    {
        return [
            'mensaje' => 'Fuiste convocado a una reunión por parte de la Academia de '. $this->reunion->academia->nombre,
            'inicio' => $this->reunion->inicio,
            'lugar' => $this->reunion->lugar,
            'url' => route('reuniones.show', $this->reunion->id),
        ];
    }
}
