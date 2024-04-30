<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public function __invoke()
    {
        return view('railway.config.index');
    }
}
