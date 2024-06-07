<?php

namespace App\Livewire\Railway\Achievement;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\Achievement;
use App\Models\Railway\Core\AchieveReward;
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

    public function export()
    {
        $achievements = Achievement::all()->toJson();
        $rewards = AchieveReward::all()->toJson();

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
            $data = json_decode(\Storage::get('data/achievement.json'), true);

            foreach ($data as $item) {
                $achievement = Achievement::create([
                    'id' => $item['id'],
                    'sector' => $item['sector'],
                    'level' => $item['level'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'action' => $item['action'],
                    'goal' => $item['goal'],
                ]);

                foreach ($item['rewards'] as $reward) {
                    $achieveReward = AchieveReward::create([
                        'id' => $reward['id'],
                        'name' => $reward['name'],
                        'description' => $reward['description'],
                        'type_reward' => $reward['type_reward'],
                        'amount_reward' => $reward['amount_reward'],
                    ]);

                    \DB::connection('railway')->table('achievements_rewards')->insert([
                        'achievement_id' => $achievement->id,
                        'reward_id' => $achieveReward->id,
                    ]);
                }
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
            'achievements' => Achievement::with('rewards')
                ->when($this->bySector, fn($query) => $query->where('sector', $this->bySector))
                ->when($this->byLevel, fn($query) => $query->where('level', $this->byLevel))
                ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),

        ]);
    }
}
