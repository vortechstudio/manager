<?php

namespace App\Notifications\Users;

use App\Models\User\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AvertissementNotification extends Notification
{
    public function __construct(
        public User $user,
        public string $reason
    ) {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), 'VORTECH LAB ADVISOR')
            ->error()
            ->subject('Avertissement à votre encontre')
            ->greeting('Cher '.$this->user->name)
            ->line("Malgré nos relances pour non respect des conditions d'utilisation de Vortech Lab, vous avez persistés à ne pas résoudre les problèmes qui ont énuméré lors de nos précédentes notifications.")
            ->line('Nous sommes obliger de vous notifier ce '.$this->countAdvertissementString().' à votre encontre.')
            ->line('Par ailleurs, les informations qui posaient un problème aux conditions ont été supprimée.')
            ->line('Nous espérons, que dorénavant vous respecterez, nos conditions qui sont là pour rappel, pour discuter, commenter de manière normal et ethiques sur nos différents canaux de discussion.')
            ->line("<strong>Raison de l'avertissement </strong>: ".$this->reason)
            ->salutation('Bien cordialement');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'warning',
            'icon' => 'fa-exclamation-triangle',
            'title' => 'Avertissement à votre encontre',
            'description' => 'Un email vous à été notifier pour vous soumettre un avertissement à votre encontre',
            'time' => now(),
            'sector' => 'alerts',
        ];
    }

    private function countAdvertissementString(): string
    {
        return match ($this->user->profil->avertissement) {
            0 => 'Premier',
            1 => 'Deuxième',
            2 => 'Dernier'
        };
    }
}
