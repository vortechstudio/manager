<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;
use App\Models\Railway\Config\RailwayBonus;

class BonusController extends Controller
{
    public function __invoke()
    {
        return view('railway.bonus.index', [
            'bonuses' => RailwayBonus::all(),
        ]);
    }
}
