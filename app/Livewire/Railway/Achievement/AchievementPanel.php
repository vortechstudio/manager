<?php

namespace App\Livewire\Railway\Achievement;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\Achievement;
use App\Models\Railway\Core\AchieveReward;
use App\Models\Railway\Core\RailwayAchievement;
use App\Models\Railway\Core\RailwayAchievementReward;
use App\Models\User\Railway\UserRailwayAchievement;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AchievementPanel extends Component
{
    use LivewireAlert;

    public RailwayAchievement $achievement;

    //Form
    public string $type_reward = '';

    public int $amount_reward = 0;

    public int $selectedReward = 0;

    public function save(): void
    {
        try {
            if ($this->selectedReward != 0) {
                $reward = RailwayAchievementReward::find($this->selectedReward);
                if (! $this->achievement->rewards()->where('id', $reward->id)->exists()) {
                    $this->achievement->rewards()->create([
                        'type' => $reward->type->value,
                        'quantity' => $reward->quantity,
                        'railway_achievement_id' => $reward->railway_achievement_id,
                    ]);
                    $this->alert('success', 'Récompense créer !');
                } else {
                    $this->alert('warning', 'Cette récompense est déjà existante pour ce trophée !');
                }
            } else {
                RailwayAchievementReward::create([
                    'type' => $this->type_reward,
                    'quantity' => $this->amount_reward,
                    'railway_achievement_id' => $this->achievement->id
                ]);
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
            'users' => UserRailwayAchievement::where('railway_achievement_id', $this->achievement->id),
        ]);
    }
}
