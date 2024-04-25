<?php

namespace App\Livewire\Railway\Hubs;

use App\Models\Railway\Gare\RailwayGare;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class HubLigneTable extends Component
{
    use LivewireAlert, WithPagination;

    public RailwayGare $gare;

    public string $search = '';

    public string $orderField = 'id';

    public string $orderDirection = 'ASC';

    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'id'],
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

    public function render()
    {
        return view('livewire.railway.hubs.hub-ligne-table', [
            'lignes' => $this->gare->hub->lignes()
                ->with('start', 'end', 'stations')
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
