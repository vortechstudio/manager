<?php

namespace App\Livewire\Social;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Cercle extends Component
{
    use LivewireAlert, WithPagination;

    #[Rule('required')]
    public string $name = '';

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    protected $queryString = [
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
        try {
            \App\Models\Social\Cercle::create([
                'name' => $this->name,
            ]);
            $this->alert('success', 'Cercle créer avec succès');
            $this->dispatch('closeModal', 'cercleForm');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', "Erreur lors de l'enregistrement");
        }
    }

    public function destroy(int $cercleId): void
    {
        \App\Models\Social\Cercle::where('id', $cercleId)->delete();
        $this->alert('success', 'Cercle supprimé');
    }

    #[Title('Gestion des Cercles')]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.social.cercle', [
            'cercles' => \App\Models\Social\Cercle::orderBy($this->orderField, $this->orderDirection)
                ->paginate(5),
        ]);
    }
}
