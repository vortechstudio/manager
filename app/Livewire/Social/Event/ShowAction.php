<?php

namespace App\Livewire\Social\Event;

use App\Actions\DeleteMedia;
use App\Actions\UserAction;
use App\Enums\Social\EventStatusEnum;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ShowAction extends Component
{
    use LivewireAlert;

    public $event;

    public function destroy(int $id): void
    {
        try {
            $this->event->delete();
            (new DeleteMedia())->handle('events', $this->event->id);
            $this->alert('success', 'Event supprimé avec succès');
        } catch (\Exception $exception) {
            $this->alert('error', 'Impossible de supprimer l\'event');
        }
        $this->redirectRoute('social.events.index');
    }

    public function publish(): void
    {
        $this->event->status = EventStatusEnum::PUBLISHED;
        $this->event->published_at = now();
        $this->event->save();
        (new UserAction())->sendNotificationToUsers(
            title: 'Nouvelle evènement publier',
            message: $this->event->title
        );
        $this->alert('success', 'Évènement publie avec succès');
    }

    public function unpublish(): void
    {
        $this->event->status = EventStatusEnum::DRAFT;
        $this->event->save();
        $this->alert('success', 'Évènement dépublie avec succès');
    }

    public function render()
    {
        return view('livewire.social.event.show-action');
    }
}
