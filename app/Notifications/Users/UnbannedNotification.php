<?php

namespace App\Notifications\Users;

use App\Models\User\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnbannedNotification extends Notification
{
    public function __construct(public User $user)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), 'VORTECH LAB ADVISOR')
            ->subject("Vous n'êtes plus bannis de Vortech Studio")
            ->greeting('Cher '.$this->user->name)
            ->line('Allez la punition à asser durée, vous pouvez de nouveau acceder aux services de Vortech Studio')
            ->line('Mais attention, la prochaine punition peut être pire que la précédente !')
            ->salutation('Bien cordialement');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'success',
            'icon' => 'fa-check-circle',
            'title' => 'Déblocage de votre compte',
            'description' => "Vous n'êtes plus bannis des services de Vortech Studio",
            'time' => now(),
            'sector' => 'alerts',
        ];
    }
}
