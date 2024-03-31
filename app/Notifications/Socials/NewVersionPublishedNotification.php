<?php

namespace App\Notifications\Socials;

use App\Models\Config\Service;
use Illuminate\Notifications\Notification;

class NewVersionPublishedNotification extends Notification
{
    public function __construct(public Service $service)
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
            'icon' => 'fas fa-code-fork',
            'title' => $this->service->versions()->latest()->first()->title,
            'description' => $this->service->versions()->latest()->first()->description,
            'time' => now(),
            'sector' => 'release',
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'info',
            'icon' => 'fas fa-code-fork',
            'title' => $this->service->versions()->latest()->first()->title,
            'description' => $this->service->versions()->latest()->first()->description,
            'time' => now(),
            'sector' => 'release',
        ];
    }
}
