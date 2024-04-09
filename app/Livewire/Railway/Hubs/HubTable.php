<?php

namespace App\Livewire\Railway\Hubs;

use App\Models\Railway\Gare\RailwayGare;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class HubTable extends Component
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

    public function destroy(int $id): void
    {
        try {
            $gare = RailwayGare::find($id);
            $gare->delete();
            $this->alert('success', 'Gare supprimée avec succès');
        } catch (\Exception $exception) {
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function disabled(int $id): void
    {
        try {
            $gare = RailwayGare::find($id);
            $gare->hub()->update(['active' => false]);
            $this->alert('success', 'Gare inactiver avec succès');
        } catch (\Exception $exception) {
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function enabled(int $id): void
    {
        try {
            $gare = RailwayGare::find($id);
            $gare->hub()->update(['active' => true]);
            $this->alert('success', 'Gare activer avec succès');
        } catch (\Exception $exception) {
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function render()
    {
        return view('livewire.railway.hubs.hub-table', [
            'gares' => RailwayGare::with('weather', 'hub')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
