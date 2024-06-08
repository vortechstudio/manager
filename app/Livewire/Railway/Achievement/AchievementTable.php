<?php

namespace App\Livewire\Railway\Achievement;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\Achievement;
use App\Models\Railway\Core\AchieveReward;
use App\Models\Railway\Core\RailwayAchievement;
use App\Models\Railway\Core\RailwayAchievementReward;
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
            RailwayAchievement::create([
                'name' => $this->name,
                'slug' => \Str::slug($this->name),
                'description' => $this->description,
                'type' => $this->sector,
                'level' => $this->level,
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
            RailwayAchievement::find($trophy_id)->delete();

            $this->alert('success', 'Le trophée à été supprimée !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function export()
    {
        $achievements = RailwayAchievement::all()->toJson();
        $rewards = RailwayAchievementReward::all()->toJson();

        try {
            $achie = 'achievement.json';
            $rew = 'rewards.json';
            \Storage::put('data/' . $achie, $achievements);
            \Storage::put('data/' . $rew, $rewards);
            $this->alert('success', 'Export Effectuer !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function import()
    {
        try {
            $data_achievement = json_decode(\Storage::get('data/achievement.json'), true);
            $data_reward = json_decode(\Storage::get('data/rewards.json'), true);

            foreach ($data_achievement as $item) {
                RailwayAchievement::updateOrCreate(['id' => $item['id']],[
                    'id' => $item['id'],
                    'type' => $item['type'],
                    'level' => $item['level'],
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'description' => $item['description'],
                    'goal' => $item['goal'],
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                ]);
            }

            foreach ($data_reward as $item) {
                RailwayAchievementReward::updateOrCreate(['id' => $item['id']],[
                    'id' => $item['id'],
                    'type' => $item['type'],
                    'quantity' => $item['quantity'],
                    'railway_achievement_id' => $item['railway_achievement_id'],
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                ]);
            }

            $this->alert('success', 'Import Effectuer !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }

    }

    public function render()
    {
        return view('livewire.railway.achievement.achievement-table', [
            'achievements' => RailwayAchievement::with('rewards')
                ->when($this->bySector, fn($query) => $query->where('type', $this->bySector))
                ->when($this->byLevel, fn($query) => $query->where('level', $this->byLevel))
                ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),

        ]);
    }
}
