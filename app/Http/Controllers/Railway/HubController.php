<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;
use App\Models\Railway\Gare\RailwayGare;

class HubController extends Controller
{
    public function index()
    {
        return view('railway.hubs.index');
    }
}
