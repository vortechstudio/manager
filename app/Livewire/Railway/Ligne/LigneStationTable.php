<?php

namespace App\Livewire\Railway\Ligne;

use App\Actions\Railway\LigneStationAction;
use App\Models\Railway\Gare\RailwayGare;
use App\Models\Railway\Ligne\RailwayLigne;
use App\Models\Railway\Ligne\RailwayLigneStation;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class LigneStationTable extends Component
{
    use LivewireAlert, WithPagination;

    public RailwayLigne $ligne;

    public string $orderField = 'id';

    public string $orderDirection = 'ASC';

    public int $perPage = 10;

    public int $railway_gare_id = 0;

    protected $queryString = [
        'orderField' => ['except' => 'id'],
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

    public function save(): void
    {
        try {
            $latestStation = $this->ligne->stations()->latest('id')->first();
            $gare = RailwayGare::find($this->railway_gare_id);

            $station = $this->ligne->stations()->create([
                'railway_gare_id' => $this->railway_gare_id,
                'railway_ligne_id' => $this->ligne->id,
                'time' => 0,
                'distance' => 0,
            ]);

            if ($latestStation) {
                $distance = (new LigneStationAction())->calculDistance(
                    $latestStation->gare->latitude,
                    $latestStation->gare->longitude,
                    $gare->latitude,
                    $gare->longitude
                );

                $vitesse = (new LigneStationAction())->convertVitesse(
                    (new LigneStationAction())->vitesseByType($this->ligne->type->value)
                );

                $station->update([
                    'time' => (new LigneStationAction())->calculTemps($distance, $vitesse),
                    'distance' => $distance,
                ]);
                $this->ligne->update([
                    'time_min' => $this->ligne->time_min + $station->time,
                ]);

            } else {
                $station->update([
                    'time' => 0,
                    'distance' => 0,
                ]);
            }

            $this->dispatch('closeModal', 'addStation');
            $this->alert('success', 'Station ajoutée avec succès');
        } catch (\Exception $exception) {
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function destroy(int $id): void
    {
        try {
            $station = RailwayLigneStation::find($id);

            $this->ligne->update([
                'time_min' => $this->ligne->time_min - $station->time,
            ]);

            $station->delete();

            $this->alert('success', 'Station supprimée avec succès');
        } catch (\Exception $exception) {
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function render()
    {
        return view('livewire.railway.ligne.ligne-station-table', [
            'stations' => $this->ligne->stations()->with('gare', 'ligne')
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage),
        ]);
    }
}
