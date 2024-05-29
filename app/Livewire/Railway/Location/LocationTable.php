<?php

namespace App\Livewire\Railway\Location;

use App\Actions\ErrorDispatchHandle;
use App\Models\Railway\Config\RailwayRental;
use Exception;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class LocationTable extends Component
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
            $location = RailwayRental::find($id);
            $location->delete();

            if (Storage::exists('logos/rentals/' . \Str::lower($location->name) . '.webp')) {
                Storage::delete('logos/rentals/' . \Str::lower($location->name) . '.webp');
            }

            $this->alert('success', 'Le service de location a été supprimé');
        } catch (Exception $exception) {
            $this->alert('error', $exception->getMessage());
        }
    }

    public function export()
    {
        $rentals = RailwayRental::all()->toJson();
        try {
            $filename = 'railway_rentals.json';
            \Storage::put('data/beta/' . $filename, $rentals);
            \Storage::put('data/production/' . $filename, $rentals);
            $this->alert('success', 'Export Effectuer !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function import()
    {
        if (config('app.env') === 'production') {
            $rentals = json_decode(Storage::get('data/production/railway_rentals.json'), true);
        } else {
            $rentals = json_decode(Storage::get('data/beta/railway_rentals.json'), true);
        }

        foreach ($rentals as $rental) {
            RailwayRental::updateOrCreate(['id' => $rental['id']], [
                'id' => $rental['id'],
                'uuid' => $rental['uuid'],
                'name' => $rental['name'],
                'contract_duration' => $rental['contract_duration'],
                'type' => $rental['type'],
            ]);
        }
        $this->alert('success', 'Import Effectuer !');
    }

    public function render()
    {
        return view('livewire.railway.location.location-table', [
            'locations' => RailwayRental::when($this->search, fn($query, $search) => $query->where('name', 'like', '%' . $search . '%'))
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
