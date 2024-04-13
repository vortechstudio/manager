<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function index()
    {
        return view('railway.location.index');
    }
}
