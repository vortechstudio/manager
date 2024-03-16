<?php

namespace App\Livewire\Social;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Cercle extends Component
{
    use LivewireAlert,WithPagination;

    #[Rule('required')]
    public string $name = '';

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    public bool $showModal = false;

    #[Locked]
    public int $cercle_id;

    public ?\App\Models\Social\Cercle $cercle;

    protected $queryString = [
        'orderField' => ['except' => 'name'],
        'orderDirection' => ['except' => 'ASC'],
    ];

    public function setOrderField(string $name)
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

    public function edit(int $cercle_id): void
    {
        $this->cercle = \App\Models\Social\Cercle::where('id', $cercle_id)->first();
        $this->showModal = true;
        $this->cercle_id = $cercle_id;

        $this->name = $this->cercle->name;
    }

    public function save(): void
    {
        $this->validate();
        if (empty($this->cercle)) {
            $cercle = \App\Models\Social\Cercle::create([
                'name' => $this->name,
            ]);
        } else {
            $cercle = $this->cercle;
            $cercle->update([
                'name' => $this->name,
            ]);
        }

        $this->dispatch('closeModal', modalId: '#cercleForm');
        $this->reset('cercle', 'name', 'showModal');
        $this->alert('success', 'Cercle enregistré');
    }

    public function destroy(int $cercleId)
    {
        \App\Models\Social\Cercle::where('id', $cercleId)->delete();
        $this->alert('success', 'Cercle supprimé');
    }

    public function resetModal(): void
    {
        $this->reset('cercle', 'name', 'showModal');
    }

    #[Title('Gestion des Articles')]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.social.cercle', [
            'cercles' => \App\Models\Social\Cercle::orderBy($this->orderField, $this->orderDirection)
                ->paginate(5),
        ]);
    }
}
