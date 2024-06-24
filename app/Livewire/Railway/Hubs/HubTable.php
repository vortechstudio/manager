<?php

namespace App\Livewire\Railway\Hubs;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Gare\RailwayGare;
use App\Models\Railway\Gare\RailwayHub;
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

    public function export(): void
    {
        $gares = RailwayGare::all()->toJson();
        $hubs_beta = RailwayHub::where('status', 'beta')->get()->toJson();
        $hubs_prod = RailwayHub::where('status', 'production')->get()->toJson();

        try {
            \Storage::put('data/railway_gares.json', $gares);
            \Storage::put('data/beta/railway_hubs.json', $hubs_beta);
            \Storage::put('data/production/railway_hubs.json', $hubs_prod);
            $this->alert('success', 'Export Effectuer !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function import(): void
    {
        $gares = json_decode(\Storage::get('data/railway_gares.json'), true);
        $hubs = json_decode(\Storage::get('data/beta/railway_hubs.json'), true);

        foreach ($gares as $gare) {
            $this->createGare($gare);
        }

        foreach ($hubs as $hub) {
            $this->createHub($hub);
        }

        $this->alert('success', 'Import Effectuer !');
    }

    public function render()
    {
        return view('livewire.railway.hubs.hub-table', [
            'gares' => RailwayGare::with('weather', 'hub')
                ->when($this->search, fn ($query, $search) => $query->where('name', 'like', '%'.$search.'%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }

    private function createGare(mixed $gare)
    {
        return RailwayGare::updateOrCreate(['id' => $gare['id']], [
            'id' => $gare['id'],
            'uuid' => $gare['uuid'],
            'name' => $gare['name'],
            'type' => $gare['type'],
            'latitude' => $gare['latitude'],
            'longitude' => $gare['longitude'],
            'city' => $gare['city'],
            'pays' => $gare['pays'],
            'freq_base' => $gare['freq_base'],
            'hab_city' => $gare['hab_city'],
            'transports' => $gare['transports'],
            'equipements' => $gare['equipements'],
        ]);
    }

    private function createHub(mixed $hub): void
    {
        RailwayHub::updateOrCreate(['id' => $hub['id']], [
            'id' => $hub['id'],
            'status' => $hub['status'],
            'active' => $hub['active'],
            'price_base' => $hub['price_base'],
            'taxe_hub_price' => $hub['taxe_hub_price'],
            'railway_gare_id' => $hub['railway_gare_id']
        ]);
    }
}
