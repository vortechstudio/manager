<?php

namespace App\Livewire\Social\Event;

use App\Models\Social\Event;
use Livewire\Component;

class PanelStat extends Component
{
    public Event $event;

    public function render()
    {
        $subscribersCount = $this->event->participants()
            ->verified()
            ->count();
        $subscribersPreviousDay = $this->event->participants()
            ->verified()
            ->whereDay('user_event.created_at', now()->subDay())
            ->count();
        $subscribersNow = $this->event->participants()
            ->verified()
            ->whereDay('user_event.created_at', now())
            ->count();

        if ($subscribersPreviousDay == 0) {
            $avgSubscribers = 0;
        } else {
            $avgSubscribers = (($subscribersNow - $subscribersPreviousDay) / $subscribersPreviousDay) * 100;
        }

        return view('livewire.social.event.panel-stat', compact('subscribersCount', 'avgSubscribers'));
    }
}
