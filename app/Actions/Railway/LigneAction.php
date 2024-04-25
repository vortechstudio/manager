<?php

namespace App\Actions\Railway;

use App\Models\Railway\Ligne\RailwayLigne;

class LigneAction
{
    public function calculatePrice(RailwayLigne $ligne): float|int
    {
        return ($ligne->distance * $ligne->time_min) * $ligne->stations()->count();
    }
}
