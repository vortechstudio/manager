<?php

namespace App\Livewire\Railway\Hubs;

use App\Actions\ErrorDispatchHandle;
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

    public function export()
    {
        $gares = RailwayGare::with('weather', 'hub')->get()->toJson();
        try {
            $filename = 'railway_gares.json';
            \Storage::put('data/beta/'.$filename, $gares);
            \Storage::put('data/production/'.$filename, $gares);
            $this->alert('success', 'Export Effectuer !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function import()
    {
        $gares = json_decode(\Storage::get('data/beta/railway_gares.json'), true);

        foreach ($gares as $gare) {
            $e = $this->createGare($gare);
            if ($e->type->value == 'large' || $e->type->value == 'terminus') {
                $this->createHub($e, $gare);
            }
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

    private function createHub(RailwayGare $e, mixed $gare)
    {
        $e->hub()->updateOrCreate(['id' => $gare['hub']['id']], [
            'price_base' => $gare['hub']['price_base'],
            'taxe_hub_price' => $gare['hub']['taxe_hub_price'],
            'active' => $gare['hub']['active'],
            'status' => $gare['hub']['status'],
            'railway_gare_id' => $e->id,
        ]);
    }
}
