<?php

namespace App\Livewire\Railway\Quests;

use App\Actions\Railway\LevelAction;
use App\Models\Railway\Config\RailwayLevel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class LevelTable extends Component
{
    use LivewireAlert, WithPagination;

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

    public function save(): void
    {
        try {
            (new LevelAction())->handle();
            $this->alert('success', 'Niveaux définis avec succès !');
        } catch (\Exception $exception) {
            $this->alert('error', 'Erreur lors de la création des niveaux !');
        }
    }

    public function render()
    {
        return view('livewire.railway.quests.level-table', [
            'levels' => RailwayLevel::with('reward')
                ->when($this->search, fn ($query, $search) => $query->where('id', 'like', "%{$search}%"))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
