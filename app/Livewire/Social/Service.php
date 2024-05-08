<?php

namespace App\Livewire\Social;

use App\Actions\DeleteMedia;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Service extends Component
{
    use LivewireAlert, WithPagination;

    #[Rule('required', 'min:3', 'max:255')]
    public string $name = '';

    #[Rule('required')]
    public string $type = '';

    #[Rule('required')]
    public string $description = '';

    public string $page_content = '';

    #[Rule('required')]
    public string $status = '';

    public string $url = '';

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    public string $search = '';

    public int $perPage = 5;

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
        $this->validate();

        try {
            \App\Models\Config\Service::create([
                'name' => $this->name,
                'type' => $this->type,
                'description' => $this->description,
                'page_content' => $this->page_content,
                'status' => $this->status,
                'url' => $this->url,
            ]);
            $this->alert('success', 'Service sauvegardé avec succes');
            $this->dispatch('closeModal', modalId: 'addService');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', 'Impossible de sauvegarder le service');
        }
    }

    public function destroy(int $serviceId): void
    {
        $service = \App\Models\Config\Service::find($serviceId);
        try {
            $service->delete();
            (new DeleteMedia())->handle('service', $serviceId);
            $this->alert('success', 'Service supprimé avec succes');
        } catch (\Exception $exception) {
            $this->alert('error', 'Impossible de supprimer le service');
        }
    }

    #[Title('Gestion des Services')]
    public function render()
    {
        return view('livewire.social.service', [
            'services' => \App\Models\Config\Service::where('name', 'like', '%'.$this->search.'%')
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
