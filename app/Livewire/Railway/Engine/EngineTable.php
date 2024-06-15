<?php

namespace App\Livewire\Railway\Engine;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Core\ShopItem;
use App\Models\Railway\Engine\RailwayEngine;
use App\Models\Railway\Engine\RailwayEnginePrice;
use App\Models\Railway\Engine\RailwayEngineShop;
use App\Models\Railway\Engine\RailwayEngineTechnical;
use App\Services\Models\Railway\Engine\RailwayEnginePriceAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EngineTable extends Component
{
    use LivewireAlert, WithFileUploads, WithPagination;

    public string $search = '';

    public string $orderField = 'name';

    public string $orderDirection = 'ASC';

    public int $perPage = 10;

    //Form
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

    public function destroy(int $engine_id): void
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

    public function export(): void
    {
        try {
            $this->exportBetaEngine();
            $this->exportProdEngine();
            $this->alert('success', 'Export Effectuer !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function exportBetaEngine()
    {
        $engines = RailwayEngine::where('status', 'beta')->get();
        $prices = collect();
        $technicals = collect();
        $shops = collect();
        $rentals = collect();

        foreach ($engines as $engine) {
            $prices->add($engine->price);
            $technicals->add($engine->technical);
            $shops->add($engine->shop);
            $rentals->add($engine->rentals);
        }

        \Storage::put('data/beta/railway_engines.json', $engines->toJson());
        \Storage::put('data/beta/railway_engine_prices.json', $prices->toJson());
        \Storage::put('data/beta/railway_engine_technicals.json', $technicals->toJson());
        \Storage::put('data/beta/railway_engine_shops.json', $shops->toJson());
        \Storage::put('data/beta/railway_engine_rentals.json', $rentals->toJson());
    }
    public function exportProdEngine()
    {
        $engines = RailwayEngine::where('status', 'prod')->get();
        $prices = collect();
        $technicals = collect();
        $shops = collect();
        $rentals = collect();

        foreach ($engines as $engine) {
            $prices->add($engine->price);
            $technicals->add($engine->technical);
            $shops->add($engine->shop);
            $rentals->add($engine->rentals);
        }

        \Storage::put('data/production/railway_engines.json', $engines->toJson());
        \Storage::put('data/production/railway_engine_prices.json', $prices->toJson());
        \Storage::put('data/production/railway_engine_technicals.json', $technicals->toJson());
        \Storage::put('data/production/railway_engine_shops.json', $shops->toJson());
        \Storage::put('data/production/railway_engine_rentals.json', $rentals->toJson());
    }

    public function import()
    {
        try {
            if($this->status == 'beta') {
                $this->importBetaEngine();
            } else {
                $this->importProdEngine();
            }
            $this->alert('success', "L'import à été effectué");
            $this->dispatch('closeModal', 'import');
        }catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu');
        }
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

    private function importBetaEngine()
    {
        $engines = json_decode(\Storage::get('data/beta/railway_engines.json'), true);
        $prices = json_decode(\Storage::get('data/beta/railway_engine_prices.json'), true);
        $technicals = json_decode(\Storage::get('data/beta/railway_engine_technicals.json'), true);
        $shops = json_decode(\Storage::get('data/beta/railway_engine_shops.json'), true);
        $rentals = json_decode(\Storage::get('data/beta/railway_engine_rentals.json'), true);

        foreach ($engines as $engine) {
            RailwayEngine::updateOrCreate(['id' => $engine['id']], [
                'id' => $engine['id'],
                'name' => $engine['name'],
                'uuid' => $engine['uuid'],
                'type_transport' => $engine['type_transport'],
                'type_train' => $engine['type_train'],
                'type_energy' => $engine['type_energy'],
                'duration_maintenance' => $engine['duration_maintenance'],
                'active' => $engine['active'],
                'in_shop' => $engine['in_shop'],
                'in_game' => $engine['in_game'],
                'status' => $engine['status']
            ]);
        }

        foreach ($prices as $price) {
            RailwayEnginePrice::updateOrCreate(['id' => $price['id']], [
                'id' => $price['id'],
                'achat' => $price['achat'],
                'in_reduction' => $price['in_reduction'],
                'percent_reduction' => $price['percent_reduction'],
                'maintenance' => $price['maintenance'],
                'location' => $price['location'],
                'railway_engine_id' => $price['railway_engine_id']
            ]);
        }

        foreach ($technicals as $technical) {
            RailwayEngineTechnical::updateOrCreate(['id' => $technical['id']], [
                'id' => $technical['id'],
                'essieux' => $technical['essieux'],
                'velocity' => $technical['velocity'],
                'motor' => $technical['motor'],
                'marchandise' => $technical['marchandise'],
                'nb_marchandise' => $technical['nb_marchandise'],
                'nb_wagon' => $technical['nb_wagon'],
                'puissance' => $technical['puissance'],
                'railway_engine_id' => $technical['railway_engine_id']
            ]);
        }

        if(count($shops) > 0) {
            foreach ($shops as $shop) {
                RailwayEngineShop::updateOrCreate(['id' => $shop['id']], [
                    'id' => $shop['id'],
                    'price' => $shop['price'],
                    'money' => $shop['money'],
                    'railway_engine_id' => $shop['railway_engine_id'],
                    'created_at' => $shop['created_at'],
                    'updated_at' => $shop['updated_at']
                ]);
            }
        }

        foreach ($rentals as $rental) {
            \DB::connection('railway')->table('railway_engine_rentals')
                ->updateOrInsert(['id' => $rental['id']], [
                    'id' => $rental['id'],
                    'railway_engine_id' => $rental['railway_engine_id'],
                    'railway_rental_id' => $rental['railway_rental_id'],
                    'created_at' => $rental['created_at'],
                    'updated_at' => $rental['updated_at']
                ]);
        }
    }
}
