<?php

namespace App\Livewire\Social;

use App\Actions\DeleteMedia;
use App\Models\Social\Event;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class EventTable extends Component
{
    use LivewireAlert, WithPagination;

    public string $orderField = 'title';

    public string $orderDirection = 'ASC';

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'title'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    public function setOrderField(string $name): void
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function destroy(int $event_id)
    {
        $event = Event::find($event_id);
        try {
            $event->delete();
            (new DeleteMedia())->handle('events', $event->id);
            $this->alert('success', 'Event supprimé avec succès');
        } catch (\Exception $exception) {
            $this->alert('error', 'Impossible de supprimer l\'event');
        }
    }

    public function publish(int $event_id)
    {
        $event = Event::find($event_id);
        try {
            $event->update([
                'status' => \App\Enums\Social\EventStatusEnum::PUBLISHED,
                'published_at' => now(),
            ]);
            $this->alert('success', 'Évènement publie avec succès');
        } catch (\Exception $exception) {
            $this->alert('error', 'Impossible de publier l\'event');
        }
    }

    public function unpublish(int $event_id)
    {
        $event = Event::find($event_id);
        try {
            $event->update([
                'status' => \App\Enums\Social\EventStatusEnum::DRAFT,
            ]);
            $this->alert('success', 'Évènement dépublie avec succès');
        } catch (\Exception $exception) {
            $this->alert('error', 'Impossible de dépublier l\'event');
        }
    }

    public function render()
    {
        return view('livewire.social.event-table', [
            'events' => Event::where('title', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(10),
        ]);
    }
}
