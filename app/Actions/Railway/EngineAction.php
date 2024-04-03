<?php

namespace App\Actions\Railway;

class EngineAction extends EngineSelectAction
{
    public function calcTarifAchat($type_train, $type_energy, $type_motor, $type_marchandise, $valEssieux, $nbWagon = 1)
    {
        $train = match ($type_train) {
            'motrice' => 10000,
            'voiture' => 2500,
            'automotrice' => 20000,
            'bus' => 1000
        };

        $energy = match ($type_energy) {
            'vapeur' => 500,
            'diesel' => 1300,
            'electrique' => 3500,
            'hybride' => 4300,
            'none' => 0
        };

        if ($type_train == 'automotrice') {
            $wagon = 2500 * $nbWagon;
        } else {
            $wagon = 0;
        }

        $calc = ($train + $energy + $wagon + $valEssieux) *
            self::selectorTypeTrain($type_train, 'coef') *
            self::selectorTypeEnergy($type_energy, 'coef') *
            self::selectorTypeMotor($type_motor, 'coef') *
            self::selectorTypeMarchandise($type_marchandise, 'coef');

        return $calc;
    }

    public function calcPriceMaintenance($duration, $val_essieux)
    {
        $calc = $duration * $val_essieux;
        if ($calc >= 100) {
            return $calc / 10;
        }

        return $calc;
    }

    public function calcPriceLocation($price_achat)
    {
        return $price_achat / 30 / 1.2;
    }

    public function calcDurationMaintenance($essieux, $automotrice = false, $nbWagon = 1)
    {
        $min_init = 15;
        $calcEssieux = $min_init + self::getDataCalcForEssieux($essieux, $automotrice, $nbWagon);

        return now()->startOfDay()->addMinutes($calcEssieux);
    }

    public function getDataCalcForEssieux($essieux, $automotrice = false, $nbWagon = 1)
    {
        $bogeys = str_split($essieux);
        $calc = 2;

        foreach ($bogeys as $bogey) {
            $calc *= match ($bogey) {
                'C' => 3,
                'D' => 4,
                'E' => 5,
                'F' => 6,
                'G' => 7,
                'H' => 8,
                'I' => 9,
                'J' => 10,
                'K' => 11,
                'L' => 12,
                'M' => 13,
                'N' => 14,
                'O' => 15,
                'P' => 16,
                'Q' => 17,
                'R' => 18,
                'S' => 19,
                'T' => 20,
                'U' => 21,
                'V' => 22,
                'W' => 23,
                'X' => 24,
                'Y' => 25,
                'Z' => 26,
                default => 2
            };
        }

        if ($automotrice) {
            return ($calc / 100) * $nbWagon;
        } else {
            return $calc / 100;
        }
    }
}
