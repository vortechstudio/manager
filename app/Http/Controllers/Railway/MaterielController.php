<?php

namespace App\Http\Controllers\Railway;

use App\Actions\Railway\EngineAction;
use App\Http\Controllers\Controller;
use App\Models\Railway\Engine\RailwayEngine;
use Illuminate\Http\Request;

class MaterielController extends Controller
{
    public function index()
    {
        return view('railway.materiels.index');
    }

    public function create()
    {
        return view('railway.materiels.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required',
            'type_train' => 'required',
            'type_transport' => 'required',
            'type_energy' => 'required',
            'type_marchandise' => 'required',
            'essieux' => 'required',
            'velocity' => 'required',
            'type_motor' => 'required',
        ]);

        $maintenanceDuration = (new EngineAction())->calcDurationMaintenance(
            $request->get('essieux'),
            $request->get('type_train') == 'automotrice',
            $request->get('type_train') == 'automotrice' ? $request->get('nb_wagon') : 1
        );

        $valeurEssieux = (new EngineAction())->getDataCalcForEssieux(
            essieux: $request->get('essieux'),
            automotrice: $request->get('type_train') == 'automotrice',
            nbWagon: $request->get('type_train') == 'automotrice' ? $request->get('nb_wagon') : 1
        );

        $price_achat = (new EngineAction())->calcTarifAchat(
            type_train: $request->get('type_train'),
            type_energy: $request->get('type_energy'),
            type_motor: $request->get('type_motor'),
            type_marchandise: $request->get('type_marchandise'),
            valEssieux: $valeurEssieux,
            nbWagon: $request->get('type_train') == 'automotrice' ? $request->get('nb_wagon') : 1
        );

        $price_maintenance = (new EngineAction())->calcPriceMaintenance(
            duration: (new EngineAction())->calcDurationMaintenance($request->get('essieux'))->diffInMinutes(now()->startOfDay()), val_essieux: $valeurEssieux
        );

        $price_location = (new EngineAction())->calcPriceLocation($price_achat);

        try {
            $engine = RailwayEngine::create([
                'name' => $request->get('name'),
                'uuid' => \Str::uuid(),
                'type_transport' => $request->get('type_transport'),
                'type_train' => $request->get('type_train'),
                'type_energy' => $request->get('type_energy'),
                'duration_maintenance' => $maintenanceDuration,
                'active' => $request->has('active'),
                'in_shop' => $request->has('in_shop'),
                'in_game' => $request->has('in_game'),
                'status' => $request->get('visual'),
            ]);

            $engine->technical()->create([
                'essieux' => $request->get('essieux'),
                'velocity' => $request->get('velocity'),
                'motor' => $request->get('type_motor'),
                'marchandise' => $request->get('type_marchandise'),
                'nb_marchandise' => $request->get('nb_marchandise'),
                'nb_wagon' => $request->get('nb_wagon'),
                'railway_engine_id' => $engine->id,
            ]);

            $engine->price()->create([
                'achat' => $price_achat,
                'maintenance' => $price_maintenance,
                'in_reduction' => false,
                'location' => $price_location,
                'railway_engine_id' => $engine->id,
            ]);

            if ($request->get('in_shop')) {
                $engine->shop()->create([
                    'money' => $request->get('money_shop'),
                    'price' => $request->get('price_shop'),
                    'railway_engine_id' => $engine->id,
                ]);
            }
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), $exception->getTrace());
            toastr()
                ->addError('Erreur lors de la création du matériel roulant');
        }

        toastr()
            ->addSuccess('Materiel '.$request->get('name').' ajouter avec succes');

        toastr()
            ->addInfo('Installer les images dans les dossiers correspondant. (engines/types_train/slugify_name.gif');

        return redirect()->route('railway.materiels.index');
    }
}
