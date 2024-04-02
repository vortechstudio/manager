<?php

namespace App\Notifications\Socials;

use Illuminate\Notifications\Notification;

class IsPublishNotification extends Notification
{
    public function __construct(public string $type, public $model)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => $this->getInfoFromType('type'),
            'icon' => $this->getInfoFromType('icon'),
            'title' => $this->getInfoFromType('title'),
            'description' => $this->getInfoFromType('desc'),
            'time' => now(),
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => $this->getInfoFromType('type'),
            'icon' => $this->getInfoFromType('icon'),
            'title' => $this->getInfoFromType('title'),
            'description' => $this->getInfoFromType('desc'),
            'time' => now(),
        ];
    }

    private function getInfoFromType(string $info)
    {
        switch ($info) {
            case 'type':
                return 'info';
            case 'icon':
                switch ($this->type) {
                    case 'blog': return 'fa-newspaper';
                    case 'event': return 'fa-calendar';
                }
                break;
            case 'title':
                return $this->model->title;
            case 'desc':
                switch ($this->type) {
                    case 'blog': return $this->model->description;
                    case 'event': return $this->model->synopsis;
                }
                break;
            default: return null;
        }
    }
}
