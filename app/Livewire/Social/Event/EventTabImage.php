<?php

namespace App\Livewire\Social\Event;

use App\Jobs\FormatImageJob;
use App\Models\Social\Event;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventTabImage extends Component
{
    use LivewireAlert, WithFileUploads;

    public Event $event;

    public $header;

    public $icon;

    public $default;

    public function save()
    {
        try {
            $this->default->storeAs(
                'events/'.$this->event->id,
                'default.'.$this->default->extension(),
                'vortech'
            );

            dispatch(new FormatImageJob(
                filePath: \Storage::path('events/'.$this->event->id.'/default.'.$this->default->extension()),
                directoryUpload: Storage::path('events/'.$this->event->id),
                sector: 'event'
            ));

            $this->header->storeAs(
                'events/'.$this->event->id,
                'header.'.$this->header->extension(),
                'vortech'
            );

            dispatch(new FormatImageJob(
                filePath: \Storage::path('events/'.$this->event->id.'/header.'.$this->header->extension()),
                directoryUpload: Storage::path('events/'.$this->event->id),
                sector: 'event_header'
            ));

            $this->icon->storeAs(
                'events/'.$this->event->id,
                'icon.'.$this->icon->extension(),
                'vortech'
            );

            dispatch(new FormatImageJob(
                filePath: \Storage::path('events/'.$this->event->id.'/icon.'.$this->icon->extension()),
                directoryUpload: Storage::path('events/'.$this->event->id),
                sector: 'event_icon'
            ));

            $this->alert('success', 'Upload effectuer avec succès');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', 'Erreur lors de l\'upload des fichiers');
        }
    }

    public function render()
    {
        return view('livewire.social.event.event-tab-image');
    }
}
