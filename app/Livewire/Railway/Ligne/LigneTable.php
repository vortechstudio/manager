<?php

namespace App\Livewire\Railway\Ligne;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Ligne\RailwayLigne;
use App\Models\Railway\Ligne\RailwayLigneStation;
use Illuminate\Database\Eloquent\Builder;
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

    public int $railway_hub_id = 0;
    public string $type_ligne = '';

    public string $status = '';

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

    public function export(): void
    {
        $lignes = RailwayLigne::all()->toJson();
        $stations = RailwayLigneStation::all()->toJson();

        try {
            \Storage::put('data/railway_lignes.json', $lignes);
            \Storage::put('data/railway_ligne_stations.json', $stations);
            $this->alert('success', 'Export Effectuer !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function import(): void
    {
        $lignes = json_decode(\Storage::get('data/railway_lignes.json'), true);
        $stations = json_decode(\Storage::get('data/railway_ligne_stations.json'), true);

        foreach ($lignes as $ligne) {
            $this->createLigne($ligne);
        }

        foreach ($stations as $station) {
            $this->createStations($station);
        }

        $this->alert('success', 'Import Effectuer !');
        $this->dispatch('closeModal', 'import');
    }

    public function render()
    {
        return view('livewire.railway.ligne.ligne-table', [
            'lignes' => RailwayLigne::with('start', 'end', 'stations', 'hub')
                ->when($this->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
                ->when($this->railway_hub_id, fn(Builder $query) => $query->where('railway_hub_id', $this->railway_hub_id))
                ->when($this->type_ligne, fn(Builder $query) => $query->where('type', $this->type_ligne))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }

    private function createLigne(mixed $ligne): void
    {
        RailwayLigne::updateOrCreate(['id' => $ligne['id']], [
            'name' => $ligne['name'],
            'price' => $ligne['price'],
            'distance' => $ligne['distance'],
            'time_min' => $ligne['time_min'],
            'active' => $ligne['active'],
            'status' => $ligne['status'],
            'type' => $ligne['type'],
            'start_gare_id' => $ligne['start_gare_id'],
            'end_gare_id' => $ligne['end_gare_id'],
            'railway_hub_id' => $ligne['railway_hub_id'],
        ]);
    }

    private function createStations(mixed $station): void
    {
        RailwayLigneStation::updateOrCreate(['id' => $station['id']], [
            'id' => $station['id'],
            'distance' => $station['distance'],
            'time' => $station['time'],
            'railway_gare_id' => $station['railway_gare_id'],
            'railway_ligne_id' => $station['railway_ligne_id']
        ]);
    }
}
