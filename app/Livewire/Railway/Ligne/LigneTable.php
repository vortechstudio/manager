<?php

namespace App\Livewire\Railway\Ligne;

use App\Models\Railway\Ligne\RailwayLigne;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class LigneTable extends Component
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

    public function disabled(int $id): void
    {
        try {
            RailwayLigne::find($id)
                ->update([
                    'active' => false,
                ]);

            $this->alert('success', 'La ligne à été désactivé');
        } catch (\Exception $exception) {
            $this->alert('error', 'Oops! Something went wrong.');
            \Log::emergency($exception->getMessage(), [$exception]);
        }
    }

    public function enable(int $id): void
    {
        try {
            RailwayLigne::find($id)
                ->update([
                    'active' => true,
                ]);

            $this->alert('success', 'La ligne à été activé');
        } catch (\Exception $exception) {
            $this->alert('error', 'Oops! Something went wrong.');
            \Log::emergency($exception->getMessage(), [$exception]);
        }
    }

    public function destroy(int $id): void
    {
        try {
            RailwayLigne::find($id)->delete();
            $this->alert('success', 'Ligne supprimée avec succès');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', 'Oops! Something went wrong.');
        }
    }

    public function render()
    {
        return view('livewire.railway.ligne.ligne-table', [
            'lignes' => RailwayLigne::with('start', 'end', 'stations', 'hub')
                ->when($this->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
