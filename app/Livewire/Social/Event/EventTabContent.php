<?php

namespace App\Livewire\Social\Event;

use App\Models\Social\Event;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EventTabContent extends Component
{
    use LivewireAlert;

    public Event $event;

    public string $contenue;

    public function mount(): void
    {
        $this->contenue = $this->event->contenue;
    }

    public function save(): void
    {
        try {
            $this->event->update([
                'contenue' => $this->contenue,
            ]);

            $this->alert('success', 'Evènement mis à jour');
            $this->dispatch('closeModal', 'editContent');
        } catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors de la mise à jour de l\'évènement');
            \Log::emergency($exception->getMessage(), [$exception]);
        }
    }

    public function render()
    {
        return view('livewire.social.event.event-tab-content');
    }
}
