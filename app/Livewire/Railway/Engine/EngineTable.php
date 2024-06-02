<?php

namespace App\Livewire\Railway\Engine;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Engine\RailwayEngine;
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
                \Storage::delete('engines/automotrice/'.$engine->slug.'-'.$i.'.gif');
            }
        } else {
            \Storage::delete('engines/'.$engine->type_train->value.'/'.$engine->slug.'.gif');
        }

        $engine->delete();

        $this->alert('success', 'Le matériel est maintenant supprimé');
    }

    public function export(): void
    {
        $beta_engines = RailwayEngine::with('price', 'technical', 'shop', 'rentals')->where('status', 'beta')->get()->toJson();
        $prod_engines = RailwayEngine::where('status', 'production')->get()->toJson();

        try {
            $filename = 'railway_engines.json';
            \Storage::put('data/beta/'.$filename, $beta_engines);
            \Storage::put('data/production/'.$filename, $prod_engines);
            $this->alert('success', 'Export Effectuer !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function createEngine($data)
    {
        return RailwayEngine::updateOrCreate(['id' => $data['id']], [
            'uuid' => $data['uuid'],
            'name' => $data['name'],
            'type_transport' => $data['type_transport'],
            'type_train' => $data['type_train'],
            'type_energy' => $data['type_energy'],
            'duration_maintenance' => $data['duration_maintenance'],
            'active' => $data['active'],
            'in_shop' => $data['in_shop'],
            'in_game' => $data['in_game'],
            'status' => $data['status'],
        ]);
    }

    private function getEnginesBasedOnStatus()
    {
        $file = $this->status == 'beta' ? 'data/beta/railway_engines.json' : 'data/production/railway_engines.json';

        return json_decode(\Storage::get($file), true);
    }

    public function import(): void
    {
        $engines = $this->getEnginesBasedOnStatus();

        foreach ($engines as $engine) {
            $e = $this->createEngine($engine)->first();
            $this->createPrice($e, $engine);
            $this->createTechnical($e, $engine);
            $this->createShop($e, $engine);
            $this->createRentals($e, $engine);
        }

        $this->alert('success', 'Import effectuer avec succès');
        $this->dispatch('closeModal', 'import');
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

    private function createPrice(RailwayEngine|array|\LaravelIdea\Helper\App\Models\Railway\Engine\_IH_RailwayEngine_C $e, mixed $engine): void
    {
        $e->price()->updateOrCreate(['id' => $engine['price']['id']], [
            'achat' => $engine['price']['achat'],
            'in_reduction' => $engine['price']['in_reduction'],
            'percent_reduction' => $engine['price']['percent_reduction'],
            'maintenance' => $engine['price']['maintenance'],
            'location' => $engine['price']['location'],
            'created_at' => $engine['price']['created_at'],
            'updated_at' => $engine['price']['updated_at'],
            'railway_engine_id' => $engine['price']['railway_engine_id'],
        ]);
    }

    private function createTechnical(RailwayEngine|array|\LaravelIdea\Helper\App\Models\Railway\Engine\_IH_RailwayEngine_C $e, mixed $engine): void
    {
        $e->technical()->updateOrCreate(['id' => $engine['technical']['id']], [
            'essieux' => $engine['technical']['essieux'],
            'velocity' => $engine['technical']['velocity'],
            'motor' => $engine['technical']['motor'],
            'marchandise' => $engine['technical']['marchandise'],
            'nb_marchandise' => $engine['technical']['nb_marchandise'],
            'nb_wagon' => $engine['technical']['nb_wagon'],
            'railway_engine_id' => $engine['technical']['railway_engine_id'],
        ]);
    }

    private function createShop(RailwayEngine|array|\LaravelIdea\Helper\App\Models\Railway\Engine\_IH_RailwayEngine_C $e, mixed $engine): void
    {
        if ($engine['shop'] !== null) {
            $e->shop()->updateOrCreate(['id' => $engine['id']], [
                'price' => $engine['shop']['price'],
                'money' => $engine['shop']['money'],
                'created_at' => $engine['shop']['created_at'],
                'updated_at' => $engine['shop']['updated_at'],
                'railway_engine_id' => $engine['shop']['railway_engine_id'],
            ]);
        }
    }

    private function createRentals(RailwayEngine|array|\LaravelIdea\Helper\App\Models\Railway\Engine\_IH_RailwayEngine_C $e, mixed $engine): void
    {
        foreach ($engine['rentals'] as $rental) {
            $e->rentals()->updateOrCreate(['id' => $engine['id']], [
                'railway_engine_id' => $rental['railway_engine_id'],
                'railway_rental_id' => $rental['railway_rental_id'],
                'created_at' => $rental['created_at'],
                'updated_at' => $rental['updated_at'],
            ]);
        }
    }
}
