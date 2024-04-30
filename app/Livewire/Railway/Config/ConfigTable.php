<?php

namespace App\Livewire\Railway\Config;

use App\Models\Railway\Config\RailwaySetting;
use Livewire\Component;

class ConfigTable extends Component
{
    public string $search = '';

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    public int $perPage = 10;

    // Champs Formulaire
    public string $name = '';

    public string $value = '';

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

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        try {
            RailwaySetting::create([
                'name' => $this->name,
                'value' => $this->value,
            ]);

            $this->alert('success', 'Enregistrement effectué avec succès');
            $this->dispatch('closeModal', 'addConfig');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        $config = RailwaySetting::find($id);
        $config->delete();
        $this->alert('success', 'Enregistrement supprimé avec succès');
    }

    public function render()
    {
        return view('livewire.railway.config.config-table', [
            'configs' => RailwaySetting::when($this->search, fn ($query) => $query->where('name', 'like', '%'.$this->search.'%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
