<?php

namespace App\Livewire\Social\Event;

use App\Models\Social\Event;
use App\Notifications\Users\SendMessageNotification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ListGraphic extends Component
{
    use LivewireAlert, WithPagination;

    public Event $event;

    public string $orderField = 'id';

    public string $orderDirection = 'ASC';

    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'id'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function setOrderField(string $name)
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function destroy(int $graphicId)
    {
        $graphic = $this->event->graphics()->findOrFail($graphicId);
        try {
            \Storage::delete("events/$this->event->id/graphics/img/$graphic->user_id.webp");
            $graphic->delete();
            $graphic->user->notify(new SendMessageNotification(
                title: 'Un graphique a été supprimé',
                sector: 'alerts',
                type: 'error',
                message: "Un média que vous avez soumis lors de l'évènement $this->event->title a été supprimé",
            ));
            $this->alert('success', 'Le graphique a bien été supprimé');
        } catch (\Exception $exception) {
            $this->alert('error', 'Impossible de supprimer le graphique');
        }
    }

    public function render()
    {
        return view('livewire.social.event.list-graphic', [
            'graphics' => $this->event->graphics()->with('event', 'user')
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
