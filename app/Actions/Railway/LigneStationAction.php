<?php

namespace App\Actions\Railway;

use AnthonyMartin\GeoLocation\GeoPoint;

class LigneStationAction
{
    public function calculDistance($lat1, $lon1, $lat2, $lon2): float|int
    {
        $geoA = new GeoPoint($lat1, $lon1);
        $geoB = new GeoPoint($lat2, $lon2);
        return $geoA->distanceTo($geoB, 'km');
    }

    public function vitesseByType(string $type): int
    {
        return match ($type) {
            'ter', 'intercity' => 160,
            'tgv' => 320,
            'tram' => 80,
            'transilien' => 120,
            'metro' => 60,
            'other' => 90
        };
    }

    public function convertVitesse(int $vitesse): float
    {
        return $vitesse / 3.6;
    }

    public function calculTemps($distance, $vitesse)
    {
        $timeInSecond = $distance / $vitesse;
        return intval(($timeInSecond * 60) / 1.8);
    }
}
