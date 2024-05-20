<?php

namespace App\Livewire\Railway\Quests;

use App\Models\Railway\Config\RailwayQuest;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class QuestTable extends Component
{
    use LivewireAlert, WithPagination;

    public string $search = '';

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    public int $perPage = 10;

    public string $name = '';

    public string $description = '';

    public string $action = '';

    public int $action_count = 0;

    public int $xp_reward = 0;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'name'],
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

    public function resetForm(): void
    {
        $this->name = '';
        $this->description = '';
        $this->xp_reward = 0;
        $this->action = '';
        $this->action_count = 0;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required',
            'xp_reward' => 'required',
            'action' => 'required',
            'action_count' => 'required',
        ]);

        try {
            RailwayQuest::create([
                'name' => $this->name,
                'description' => $this->description,
                'xp_reward' => $this->xp_reward,
                'action' => $this->action,
                'action_count' => $this->action_count,
            ]);
            $this->resetForm();
        } catch (\Exception $e) {
            $this->alert('error', 'Erreur lors de la création de la quête');
        }

        $this->alert('success', 'Quête enregistree avec succes');
    }

    public function destroy(int $id): void
    {
        try {
            $quest = RailwayQuest::find($id);
            $quest->delete();
        } catch (\Exception $e) {
            $this->alert('error', 'Erreur lors de la suppression de la quête');
        }

        $this->alert('success', 'Quête supprimée avec succes');
    }

    public function render()
    {
        return view('livewire.railway.quests.quest-table', [
            'quests' => RailwayQuest::when($this->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
