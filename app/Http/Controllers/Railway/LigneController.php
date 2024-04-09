<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;

class LigneController extends Controller
{
    public function index()
    {
        return view('railway.lignes.index');
    }
}
