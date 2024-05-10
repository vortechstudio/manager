<?php

namespace App\Livewire\Social;

use App\Actions\DeleteMedia;
use App\Models\Social\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class EventTable extends Component
{
    use LivewireAlert, WithPagination;

    public Event|Collection|null $event = null;

    public string $orderField = 'title';

    public string $orderDirection = 'ASC';

    public string $search = '';

    public string $title = '';

    public string $type_event = '';

    public int $cercle_id = 0;

    public string $star_at = '';

    public string $end_at = '';

    public string $synopsis = '';

    public string $contenue = '';

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

    public function save()
    {
        try {
            $event = Event::create([
                'title' => $this->title,
                'type_event' => $this->type_event,
                'synopsis' => $this->synopsis,
                'contenue' => $this->contenue,
                'start_at' => Carbon::parse($this->star_at),
                'end_at' => Carbon::parse($this->end_at),
            ]);

            $event->cercles()->attach($this->cercle_id);

            $this->alert('success', "L'évènement à été créer avec succès");
            $this->dispatch('closeModal', 'addEvent');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', 'Erreur lors de la création de l\'évènement');
        }
    }

    public function destroy(int $event_id): void
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

    public function publish(int $event_id): void
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

    public function unpublish(int $event_id): void
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

        if ($this->event) {
            $event = $this->event->paginate(10);
        } else {
            $event = Event::where('title', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(10);
        }

        return view('livewire.social.event-table', [
            'events' => $event,
        ]);
    }
}
