<?php

namespace App\Notifications\System;

use App\Models\Social\Event;
use Illuminate\Notifications\Notification;

class AlertStatusEventNotification extends Notification
{
    public function __construct(public Event $event, public string $message)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'info',
            'icon' => 'fa-calendar',
            'title' => 'Alerte concernant un évènement',
            'description' => $this->event->title.': '.$this->message,
            'time' => now(),
            'sector' => 'alerts',
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'info',
            'icon' => 'fa-calendar',
            'title' => 'Alerte concernant un évènement',
            'description' => $this->event->title.': '.$this->message,
            'time' => now(),
            'sector' => 'alerts',
        ];
    }
}
