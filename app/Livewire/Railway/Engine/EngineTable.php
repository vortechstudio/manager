<?php

namespace App\Livewire\Railway\Engine;

use App\Models\Railway\Engine\RailwayEngine;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class EngineTable extends Component
{
    use LivewireAlert, WithPagination;

    public string $search = '';

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    public int $perPage = 10;

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

    public function destroy(int $engine_id)
    {
        $engine = RailwayEngine::find($engine_id);
        if ($engine->type_train->value == 'automotrice') {
            for ($i = 0; $i <= $engine->technical->nb_wagon; $i++) {
                \Storage::delete('engines/automotrice/' . $engine->slug . '-' . $i . '.gif');
            }
        } else {
            \Storage::delete('engines/' . $engine->type_train->value . '/' . $engine->slug . '.gif');
        }

        $engine->delete();

        $this->alert('success', 'Le matériel est maintenant supprimé');
    }

    public function render()
    {
        return view('livewire.railway.engine.engine-table', [
            'engines' => RailwayEngine::with('price', 'technical', 'shop')
                ->where('name', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
