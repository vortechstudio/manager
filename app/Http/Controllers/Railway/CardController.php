<?php

namespace App\Http\Controllers\Railway;

use App\Http\Controllers\Controller;
use App\Models\Railway\Config\RailwayAdvantageCard;

class CardController extends Controller
{
    public function __invoke()
    {
        return view('railway.card.index', [
            'cards' => RailwayAdvantageCard::all(),
        ]);
    }
}
