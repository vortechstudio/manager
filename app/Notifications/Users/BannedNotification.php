<?php

namespace App\Notifications\Users;

use App\Models\User\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BannedNotification extends Notification
{
    public function __construct(public User $user, public string $reason)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), 'VORTECH LAB ADVISOR')
            ->error()
            ->subject('Banissement de votre compte')
            ->greeting('Cher '.$this->user->name)
            ->line("Malgré nos différentes relances et nos avertissement, vous persistez dans une démarche qui ne correspond pas à nos conditions d'utilisation.")
            ->line('De ce fais, votre compte à été bannie pour une durée de 7 jours à compter de ce jour ('.$this->user->social->banned_at->format('d/m/Y à H:i').' -> '.$this->user->social->banned_for->format('d/m/Y à H:i').')')
            ->line('<strong>Raison du banissement </strong>: '.$this->reason)
            ->salutation('Bien cordialement');
    }
}
