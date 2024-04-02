<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;

class MaterielController extends Controller
{
    public function index()
    {
        return view('railway.materiels.index');
    }
}
