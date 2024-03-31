<?php

namespace App\Livewire\Social;

use App\Enums\Config\ServiceStatusEnum;
use App\Enums\Config\ServiceTypeEnum;
use App\Services\Github\Issues;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\LaravelOptions\Options;

class Service extends Component
{
    use LivewireAlert,WithPagination, WithFileUploads;

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

    public $default;
    public $icon;

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    public string $search = '';

    public bool $showModal = false;

    #[Locked]
    public int $serviceId;

    public ?\App\Models\Config\Service $service;

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

    public function edit(int $service_id): void
    {
        $this->service = \App\Models\Config\Service::where('id', $service_id)->first();
        $this->showModal = true;
        $this->serviceId = $service_id;

        $this->name = $this->service->name;
        $this->type = $this->service->type;
        $this->description = $this->service->description;
        $this->page_content = $this->service->page_content;
        $this->status = $this->service->status;
        $this->url = $this->service->url;
    }

    public function save()
    {
        $this->validate();

        try {
            if (empty($this->service)) {
                $service = \App\Models\Config\Service::create([
                    'name' => $this->name,
                    'type' => $this->type,
                    'description' => $this->description,
                    'page_content' => $this->page_content,
                    'status' => $this->status,
                    'url' => $this->url,
                ]);
                $this->alert('success', 'Service sauvegardé avec succes');
            } else {
                $service = $this->service;
                $service->update([
                    'name' => $this->name,
                    'type' => $this->type,
                    'description' => $this->description,
                    'page_content' => $this->page_content,
                    'status' => $this->status,
                    'url' => $this->url,
                ]);
            }
            $this->dispatch('closeModal', modalId: '#serviceForm');
            $this->reset('service', 'name', 'type', 'description', 'page_content', 'status', 'url', 'showModal');
            $this->alert('success', 'Service sauvegardé avec succes');
        } catch (\Exception $exception) {
            $issue = Issues::createIssueMonolog('service', 'Impossible de sauvegarder le service', [$exception], 'emergency');
            (new Issues($issue))->createIssueFromException();
            $this->alert('error', 'Impossible de sauvegarder le service');
        }
    }

    public function destroy(int $serviceId)
    {
        $service = \App\Models\Config\Service::find($serviceId);
        try {
            $service->delete();
            $this->alert('success', 'Service supprimé avec succes');
        } catch (\Exception $exception) {
            $issue = Issues::createIssueMonolog('service', 'Impossible de supprimer le service', [$exception], 'emergency');
            (new Issues($issue))->createIssueFromException();
            $this->alert('error', 'Impossible de supprimer le service');
        }
    }

    public function resetModal(): void
    {
        $this->reset('cercle', 'name', 'type', 'description', 'page_content', 'status', 'url', 'showModal');
    }

    #[Title('Gestion des Services')]
    public function render()
    {
        return view('livewire.social.service', [
            'services' => \App\Models\Config\Service::where('name', 'like', '%'.$this->search.'%')
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5),
            'types' => Options::forEnum(ServiceTypeEnum::class)->toArray(),
            'statuses' => Options::forEnum(ServiceStatusEnum::class)->toArray(),
        ]);
    }
}
