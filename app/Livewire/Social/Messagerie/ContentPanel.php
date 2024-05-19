<?php

namespace App\Livewire\Social\Messagerie;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\Message;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ContentPanel extends Component
{
    use LivewireAlert;

    public Message $message;

    //Form
    public string $message_subject = '';

    public string $message_type = '';

    public string $message_content = '';

    public int $service_id = 0;

    public function mount()
    {
        $this->message_subject = $this->message->message_subject;
        $this->message_type = $this->message->message_type->value;
        $this->message_content = $this->message->message_content;
        $this->service_id = $this->message->service_id;
    }

    public function save()
    {
        try {
            $this->message->update([
                'message_subject' => $this->message_subject,
                'message_type' => $this->message_type,
                'message_content' => $this->message_content,
                'service_id' => $this->service_id,
            ]);

            $this->alert('success', 'Le message à bien été modifier.');
            $this->dispatch('closeModal', 'editContent');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function render()
    {
        return view('livewire.social.messagerie.content-panel');
    }
}
