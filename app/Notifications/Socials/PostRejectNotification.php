<?php

namespace App\Notifications\Socials;

use App\Models\Social\Post\Post;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostRejectNotification extends Notification
{
    public function __construct(public Post $post)
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
            ->error()
            ->subject("Blocage d'un poste sur Vortech Lab !")
            ->greeting('Cher '.$this->post->user->name)
            ->line("Le poste <strong>{$this->post->title}</strong> à fait l'objet d'un blocage pour certaine raison qui ne respecte pas nos conditions d'utilisation du service Vortech Lab.")
            ->line('Afin de débloquer votre poste, veuillez le vérifier et le faire correspondre à nos critères.')
            ->line("Si dans 7 jours, le poste n'à pas été modifier, il sera supprimer, et un avertissement vous sera transmis.<br>Pour rappel au bout de 3 avertissements, vous pouvez être soumis à une sanction allant jusqu'au banissement pur et simple de Vortech Lab.")
            ->line("Nous pensons qu'il s'agit simplement d'un moment d'égarement qui ne ce reproduira pas.")
            ->salutation('Bien cordialement');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'danger',
            'icon' => 'fa-xmark',
            'title' => 'Alerte concernant un de vos postes',
            'description' => "Le poste : <strong>{$this->post->title}</strong> à fait l'objet d'un blocage par un modérateur.",
            'time' => now(),
            'sector' => 'alerts',
        ];
    }
}
