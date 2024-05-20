<?php

namespace App\Livewire\Railway\Achievement;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\Achievement;
use App\Models\Railway\Core\AchieveReward;
use App\Models\User\Railway\UserRailwayAchievement;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AchievementPanel extends Component
{
    use LivewireAlert;

    public Achievement $achievement;

    //Form
    public string $name = '';

    public string $description = '';

    public string $type_reward = '';

    public int $amount_reward = 0;

    public int $selectedReward = 0;

    public function save(): void
    {
        try {
            if ($this->selectedReward != 0) {
                $reward = AchieveReward::find($this->selectedReward);
                if (! $this->achievement->rewards()->wherePivot('reward_id', $reward->id)->exists()) {
                    $this->achievement->rewards()->attach($reward);
                    $this->alert('success', 'Récompense créer !');
                } else {
                    $this->alert('warning', 'Cette récompense est déjà existante pour ce trophée !');
                }
            } else {
                $reward = AchieveReward::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'type_reward' => $this->type_reward,
                    'amount_reward' => $this->amount_reward,
                ]);
                $this->achievement->rewards()->attach($reward);
                $this->alert('success', 'Récompense créer !');
            }

            $this->dispatch('closeModal', 'addReward');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue !');
        }
    }

    public function render()
    {
        //dd(UserRailwayAchievement::where('achievement_id', $this->achievement->id)->get());
        return view('livewire.railway.achievement.achievement-panel', [
            'users' => UserRailwayAchievement::where('achievement_id', $this->achievement->id),
        ]);
    }
}
