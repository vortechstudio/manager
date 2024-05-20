<?php

namespace App\Livewire\Social\Messagerie;

use App\Actions\ErrorDispatchHandle;
use App\Jobs\Core\RetardedMessageJob;
use App\Models\Config\Service;
use App\Models\Railway\Core\Message;
use Carbon\Carbon;
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

    //form
    public string $selectTypeMessage = '';

    public string $message_subject = '';

    public string $message_type = '';

    public string $message_content = '';

    public int $service_id = 0;

    public bool $allUser = false;

    public int $user_id = 0;

    public array $listUsers = [];

    public bool $retarded = false;

    public string $retarded_at = '';

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

    public function resetForm(): void
    {
        $this->message_subject = '';
        $this->message_type = '';
        $this->message_content = '';
        $this->service_id = 0;
        $this->retarded = false;
        $this->retarded_at = '';
    }

    public function save(): void
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

            if ($this->retarded) {
                $newDate = Carbon::parse($this->retarded_at)->diffInMinutes(now());
                dispatch(new RetardedMessageJob(
                    $message,
                    $this->allUser,
                    null
                ))->delay(now()->addMinutes($newDate));
            } else {
                if ($this->allUser) {
                    foreach (Service::find($message->service_id)->users as $user) {
                        $message->railway_messages()->create([
                            'user_id' => $user->id,
                            'message_id' => $message->id,
                        ]);
                    }
                } else {
                    $message->railway_messages()->create([
                        'user_id' => $this->user_id,
                        'message_id' => $message->id,
                    ]);
                }
            }

            $this->alert('success', 'Message envoyer avec succès');
            $this->dispatch('closeModal', 'addMessage');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', "Erreur lors de l'envoie du message !");
        }
    }

    public function destroy(int $message_id): void
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
                ->when($this->selectTypeMessage, fn ($query) => $query->where('message_type', $this->selectTypeMessage))
                ->when($this->search, fn ($query) => $query->where('name', 'like', '%'.$this->search.'%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
