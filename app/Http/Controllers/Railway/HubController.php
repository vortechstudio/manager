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

        $sncf = new SncfService();

        if ($sncf->searchGare($request->get('name')) === null) {
            toastr()
                ->addError("La gare n'existe pas");
        }

        $gare = RailwayGare::create([
            'uuid' => \Str::uuid(),
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'latitude' => $sncf->searchGare($request->get('name'))['latitude'],
            'longitude' => $sncf->searchGare($request->get('name'))['longitude'],
            'city' => $sncf->searchGare($request->get('name'))['city'],
            'pays' => $sncf->searchGare($request->get('name'))['pays'],
            'freq_base' => $sncf->searchFreq($request->get('name'))['freq'],
            'hab_city' => (new GareAction())->getHabitant($request->get('type'), $sncf->searchFreq($request->get('name'))['freq']),
            'transports' => json_encode($request->get('transports')),
            'equipements' => json_encode((new GareAction)->defineEquipements($request->get('type'))),
        ]);

        $wt = new Weather();
        $weather = $wt->getCurrentByCord($gare->latitude, $gare->longitude);
        $gare->weather()->create([
            'weather' => $weather->weather[0]->description,
            'temperature' => $weather->main->temp,
            'latest_update' => now(),
            'railway_gare_id' => $gare->id,
        ]);

        if ($request->has('is_hub')) {
            $gare->hub()->create([
                'price_base' => (new GareAction)->definePrice($request->get('type'), $request->get('nb_quai')),
                'taxe_hub_price' => (new GareAction)->defineTaxeHub((new GareAction)->definePrice($request->get('type'), $request->get('nb_quai')), $request->get('nb_quai')),
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
        return view('railway.hubs.show', compact('gare'));
    }
}
