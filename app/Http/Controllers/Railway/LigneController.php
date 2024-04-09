<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;
use App\Models\Railway\Gare\RailwayGare;
use App\Models\Railway\Ligne\RailwayLigne;
use Illuminate\Http\Request;

class LigneController extends Controller
{
    public function index()
    {
        return view('railway.lignes.index');
    }

    public function create()
    {
        return view('railway.lignes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'railway_hub_id' => 'required',
            'start_gare_id' => 'required',
            'end_gare_id' => 'required',
            'status' => 'required',
            'type' => 'required',
        ]);

        try {
            RailwayLigne::create([
                'name' => RailwayGare::find($request->get('start_gare_id'))->name . '-' . RailwayGare::find($request->get('end_gare_id'))->name,
                'price' => 0,
                'distance' => 0,
                'time_min' => 0,
                'active' => $request->has('active'),
                'status' => $request->get('status'),
                'type' => $request->get('type'),
                'start_gare_id' => $request->get('start_gare_id'),
                'end_gare_id' => $request->get('end_gare_id'),
                'railway_hub_id' => $request->get('railway_hub_id'),
            ]);

            toastr()
                ->addSuccess('La ligne a bien été ajoutée');

            return redirect()->route('railway.lignes.index');
        } catch (\Exception $exception) {
            toastr()
                ->addError('Erreur lors de l\'ajout de la ligne');

            return redirect()->back();
        }


    }
}
