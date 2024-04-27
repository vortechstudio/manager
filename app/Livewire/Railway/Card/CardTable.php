<?php

namespace App\Livewire\Railway\Card;

use App\Models\Railway\Config\RailwayAdvantageCard;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CardTable extends Component
{
    use LivewireAlert, WithPagination;

    public string $search = '';

    public string $orderField = 'description';

    public string $orderDirection = 'ASC';

    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'description'],
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
        return view('livewire.railway.card.card-table', [
            'cards' => RailwayAdvantageCard::when($this->search, fn ($query) => $query->where('description', 'like', '%'.$this->search.'%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
