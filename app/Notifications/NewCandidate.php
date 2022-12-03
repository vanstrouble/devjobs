<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCandidate extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($vacancy_id, $vacancy_name, $user_id)
    {
        $this->vacancy_id = $vacancy_id;
        $this->vacancy_name = $vacancy_name;
        $this->user_id = $user_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/notifications');

        return (new MailMessage)
                    ->line('Has recibido un nuevo candidato en tu vacante.')
                    ->line('La vacante es: ' . $this->vacancy_name)
                    ->action('Ver Notificaciones', $url)
                    ->line('¡Gracias por utilizar DevJobs!');
    }

    // Save notifications on DB
    public function toDatabase($notifiable)
    {
        return [
            'vacancy_id' => $this->vacancy_id,
            'vacancy_name' => $this->vacancy_name,
            'user_id' => $this->user_id,
        ];
    }
}
