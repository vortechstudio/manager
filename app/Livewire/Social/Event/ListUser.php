<?php

namespace App\Livewire\Social\Event;

use App\Models\Social\Event;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ListUser extends Component
{
    use LivewireAlert,WithPagination;

    public Event $event;

    public string $search = '';
    public string $orderField = 'name';
    public string $orderDirection = 'ASC';
    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'name'],
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

    public function render()
    {
        $event = $this->event->with('cercles', 'participants', 'poll', 'poll.responses')->first();

        return view('livewire.social.event.list-user', [
            'users' => $event->participants()
                ->where('name', 'like', '%'.$this->search.'%')
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
