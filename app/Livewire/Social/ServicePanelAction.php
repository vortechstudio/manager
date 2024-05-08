<?php

namespace App\Livewire\Social;

use App\Actions\DeleteMedia;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ServicePanelAction extends Component
{
    use LivewireAlert;

    public \App\Models\Config\Service $service;

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

    public string $repository = '';

    public function mount()
    {
        $this->name = $this->service->name;
        $this->type = $this->service->type->value;
        $this->description = $this->service->description;
        $this->page_content = isset($this->service->page_content) ?? '';
        $this->status = $this->service->status->value;
        $this->url = $this->service->url;
        $this->repository = $this->service->repository;
    }

    public function save()
    {
        $this->validate();

        try {
            \App\Models\Config\Service::find($this->service->id)->update([
                'name' => $this->name,
            ]);

            $this->alert('success', 'Service mise à jour avec succès !');
            $this->dispatch('closeModal', 'modalEdit');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', 'Erreur lors de la mise à jour du service !');
        }
    }

    public function steping(string $step)
    {
        try {
            \App\Models\Config\Service::find($this->service->id)->update([
                'status' => $step,
            ]);

            $this->alert('success', 'Service passer de phase');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', 'Erreur lors du changement de phase !');
        }
    }

    public function destroy()
    {
        try {
            \App\Models\Config\Service::find($this->service->id)->delete();
            (new DeleteMedia())->handle('service', $this->service->id);
            $this->alert('success', 'Service supprimé avec succes');
            $this->redirectRoute('social.services.index');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', 'Impossible de supprimer le service');
        }
    }

    public function render()
    {
        return view('livewire.social.service-panel-action');
    }
}
