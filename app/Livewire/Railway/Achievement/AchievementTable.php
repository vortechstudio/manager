<?php

namespace App\Livewire\Railway\Achievement;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\Achievement;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AchievementTable extends Component
{
    use LivewireAlert, WithPagination;

    public string $search = '';

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    public int $perPage = 10;

    public string $bySector = '';

    public string $byLevel = '';

    //Form
    public string $sector = '';

    public string $level = '';

    public string $name = '';

    public string $description = '';

    public string $action = '';

    public int $goal = 0;

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

    public function save(): void
    {
        try {
            Achievement::create([
                'sector' => $this->sector,
                'level' => $this->level,
                'name' => $this->name,
                'description' => $this->description,
                'action' => $this->action,
                'goal' => $this->goal,
            ]);

            $this->alert('success', 'Le trophée à été ajouté !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function delete(int $trophy_id): void
    {
        try {
            Achievement::find($trophy_id)->delete();

            $this->alert('success', 'Le trophée à été supprimée !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function render()
    {
        return view('livewire.railway.achievement.achievement-table', [
            'achievements' => Achievement::with('rewards')
                ->when($this->bySector, fn ($query) => $query->where('sector', $this->bySector))
                ->when($this->byLevel, fn ($query) => $query->where('level', $this->byLevel))
                ->when($this->search, fn ($query) => $query->where('name', 'like', '%'.$this->search.'%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),

        ]);
    }
}
