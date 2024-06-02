<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;
use App\Models\Railway\Config\RailwayRental;
use App\Models\Railway\Engine\RailwayEngine;
use Exception;
use Illuminate\Http\Request;
use Str;

class LocationController extends Controller
{
    public function index()
    {
        return view('railway.location.index');
    }

    public function create()
    {
        return view('railway.location.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contract_duration' => 'required|integer',
            'type' => 'required',
        ]);

        try {
            $rental = RailwayRental::create([
                'uuid' => Str::uuid(),
                'name' => $request->get('name'),
                'contract_duration' => $request->get('contract_duration'),
                'type' => json_encode($request->get('type')),
            ]);

            foreach (RailwayEngine::all() as $engine) {
                if (in_array($engine->type_transport->value, json_decode($rental->type, true))) {
                    $engine->rentals()->attach($rental->id);
                }
            }

            toastr()
                ->addSuccess('Le service de location a été enregistré');

            return redirect()->route('railway.location.index');
        } catch (Exception $exception) {
            \Log::critical("[LocationController][store] {$exception->getMessage()}", ['exception' => $exception]);
            toastr()
                ->addError($exception->getMessage());

            return redirect()->back();
        }
    }

    public function show(RailwayRental $location)
    {
        return view('railway.location.show', compact('location'));
    }
}
