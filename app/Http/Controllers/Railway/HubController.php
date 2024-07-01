<?php

namespace App\Http\Controllers\Railway;

use App\Actions\Railway\GareAction;
use App\Http\Controllers\Controller;
use App\Models\Railway\Gare\RailwayGare;
use App\Services\SncfService;
use Illuminate\Http\Request;
use RakibDevs\Weather\Weather;

class HubController extends Controller
{
    public function index()
    {
        return view('railway.hubs.index');
    }

    public function create()
    {
        return view('railway.hubs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'nb_quai' => 'required',
        ]);

        if($request->has('manual')) {
            $gare = RailwayGare::create([
                'uuid' => \Str::uuid(),
                'name' => $request->get('name'),
                'type' => $request->get('type'),
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
                'city' => $request->get('city'),
                'pays' => $request->get('pays'),
                'freq_base' => (new GareAction())->getFrequence($request->get('type')),
                'hab_city' => (new GareAction())->getHabitant($request->get('type'), (new GareAction())->getFrequence($request->get('type'))),
                'transports' => json_encode($request->get('transports')),
                'equipements' => json_encode((new GareAction)->defineEquipements($request->get('type'))),
                'nb_quai' => $request->get('nb_quai'),
            ]);
        } else {
            $sncf = new SncfService();

            if(RailwayGare::where('name', 'like', "%{$request->get('name')}%")->exists()) {
                toastr()
                    ->addError("La gare existe déjà !");

                return redirect()->back();
            }

            if ($sncf->searchGare($request->get('name')) === null) {
                toastr()
                    ->addError("La gare n'existe pas");

                return redirect()->back();
            }

            $gare = RailwayGare::create([
                'uuid' => \Str::uuid(),
                'name' => $request->get('name'),
                'type' => $request->get('type'),
                'latitude' => $sncf->searchGare($request->get('name'))['latitude'],
                'longitude' => $sncf->searchGare($request->get('name'))['longitude'],
                'city' => $sncf->searchGare($request->get('name'))['city'],
                'pays' => $sncf->searchGare($request->get('name'))['pays'],
                'freq_base' => $sncf->searchFreq($request->get('name'))['freq'] ?? 0,
                'hab_city' => (new GareAction())->getHabitant($request->get('type'), $sncf->searchFreq($request->get('name'))['freq']),
                'transports' => json_encode($request->get('transports')),
                'equipements' => json_encode((new GareAction)->defineEquipements($request->get('type'))),
                'nb_quai' => $request->get('nb_quai'),
            ]);
        }

        /*$wt = new Weather();
        $weather = $wt->getCurrentByCord($gare->latitude, $gare->longitude);
        $gare->weather()->create([
            'weather' => $weather->weather[0]->description,
            'temperature' => $weather->main->temp,
            'latest_update' => now(),
            'railway_gare_id' => $gare->id,
        ]);*/

        if ($request->has('is_hub')) {
            $price_base = (new GareAction)->definePrice($request->get('type'), $request->get('nb_quai'));
            $gare->hub()->create([
                'price_base' => $price_base,
                'taxe_hub_price' => (new GareAction)->defineTaxeHub($price_base, $request->get('nb_quai')),
                'active' => $request->has('active'),
                'status' => $request->get('status'),
                'railway_gare_id' => $gare->id,
            ]);

            toastr()
                ->addInfo('Un hub à été créer');
        }

        toastr()
            ->addSuccess('La gare a été créer');

        return redirect()->route('railway.hubs.index');
    }

    public function show(RailwayGare $gare)
    {
        $gare = $gare->load('hub', 'weather');

        $options = [
            'center' => [
                'lat' => $gare->latitude,
                'lng' => $gare->longitude,
            ],
            'googleview' => true,
            'zoom' => 18,
            'zoomControl' => true,
            'minZoom' => 3,
            'maxZoom' => 18,
        ];

        $initialMarkers = [
            [
                'position' => [
                    'lat' => $gare->latitude,
                    'lng' => $gare->longitude,
                ],
                'draggable' => false,
                'title' => $gare->name,
            ],
        ];

        return view('railway.hubs.show', compact('gare', 'options', 'initialMarkers'));
    }
}
