<?php

namespace App\Livewire\Social\Messagerie;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\Message;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class RewardPanel extends Component
{
    use LivewireAlert, WithPagination;

    public Message $message;

    public string $search = '';

    public int $perPage = 8;

    public int $reward_item_id = 0;

    //form
    public string $reward_type = '';

    public string $reward_value = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function save(): void
    {
        try {
            $this->message->rewards()
                ->create([
                    'reward_type' => $this->reward_type,
                    'reward_value' => $this->reward_value,
                    'reward_item_id' => $this->reward_item_id,
                    'message_id' => $this->message->id,
                ]);
            $this->alert('success', 'Récompense ajouté');
            $this->dispatch('closeModal', 'addReward');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function delete(int $reward_id): void
    {
        try {
            $countReadMsg = $this->message->railway_messages()->where('is_read', true)->get()->count();
            if ($countReadMsg > 0) {
                $this->alert('warning', 'Impossible de supprimer cette récompense car le message à déjà été vue et la récompense déjà réclamer !');
            }

            $this->message->rewards()->find($reward_id)->delete();
            $this->alert('success', 'Récompense supprimer');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function render()
    {
        return view('livewire.social.messagerie.reward-panel', [
            'rewards' => $this->message->rewards()
                ->when($this->search, fn ($query) => $query->where('reward_type', 'like', '%'.$this->search.'%'))
                ->paginate($this->perPage),
        ]);
    }
}
