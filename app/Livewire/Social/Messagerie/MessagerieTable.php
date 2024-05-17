<?php

namespace App\Livewire\Social\Messagerie;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\Message;
use App\Models\User\UserService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class MessagerieTable extends Component
{
    use LivewireAlert, WithPagination;

    public string $orderField = 'message_subject';

    public string $orderDirection = 'ASC';

    public string $search = '';

    public int $perPage = 5;

    public string $selectTypeMessage = '';

    public string $message_subject = '';

    public string $message_type = '';

    public string $message_content = '';

    public int $service_id = 0;

    public bool $hasReward = false;

    public string $reward_type = '';

    public int $reward_value = 0;

    public bool $allUser = false;

    public int $user_id = 0;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'message_subject'],
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

    public function resetForm()
    {
        $this->message_subject = '';
        $this->message_type = '';
        $this->message_content = '';
        $this->service_id = 0;
        $this->hasReward = false;
        $this->reward_type = '';
        $this->reward_value = 0;
    }

    public function save()
    {
        $this->validate([
            'message_subject' => 'required',
            'message_type' => 'required',
            'message_content' => 'required',
        ]);

        try {
            $message = Message::create([
                'message_subject' => $this->message_subject,
                'message_type' => $this->message_type,
                'message_content' => $this->message_content,
                'service_id' => $this->service_id,
            ]);

            if ($this->allUser) {
                foreach (UserService::with('user')->where('service_id', $this->service_id)->get() as $user) {
                    $message->railway_messages()->create([
                        'user_id' => $user->user->id,
                        'message_id' => $message->id,
                        'reward_type' => $this->reward_type,
                        'reward_value' => $this->reward_value,
                    ]);
                }
            } else {
                $message->railway_messages()
                    ->create([
                        'user_id' => $this->user_id,
                        'message_id' => $message->id,
                        'reward_type' => $this->reward_type,
                        'reward_value' => $this->reward_value,
                    ]);
            }

            $this->alert('success', 'Message envoyer avec succès');
            $this->dispatch('closeModal', 'addMessage');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', "Erreur lors de l'envoie du message !");
        }
    }

    public function destroy(int $message_id)
    {
        try {
            $message = Message::find($message_id);
            $message->delete();
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

    #[Title('Service de messagerie')]
    public function render()
    {
        return view('livewire.social.messagerie.messagerie-table', [
            'messages' => Message::with('railway_messages')
                ->when($this->selectTypeMessage, fn($query) => $query->where('message_type', $this->selectTypeMessage))
                ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
