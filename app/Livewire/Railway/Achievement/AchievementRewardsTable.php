<?php

namespace App\Livewire\Railway\Achievement;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\Achievement;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AchievementRewardsTable extends Component
{
    use LivewireAlert, WithPagination;

    public Achievement $achievement;

    public function delete(int $reward_id)
    {
        try {
            $reward = $this->achievement->rewards()->find($reward_id);
            $this->achievement->rewards()->detach($reward_id);
            $reward->delete();
            $this->alert('success', 'Récompense supprimée !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue !');
        }
    }

    public function render()
    {
        return view('livewire.railway.achievement.achievement-rewards-table', [
            'rewards' => $this->achievement->rewards,
        ]);
    }
}
