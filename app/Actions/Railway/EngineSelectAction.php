<?php

namespace App\Actions\Railway;

use App\Enums\Railway\Engine\EngineMoneyEnum;
use App\Enums\Railway\Engine\EngineTechMarchEnum;
use App\Enums\Railway\Engine\EngineTechMotorEnum;
use App\Enums\Railway\Engine\RailwayEngineEnergyEnum;
use App\Enums\Railway\Engine\RailwayEngineTrainEnum;
use Spatie\LaravelOptions\Options;

class EngineSelectAction
{
    public function selectorTypeTrain($search = null, $field = null)
    {
        $types = collect(Options::forEnum(RailwayEngineTrainEnum::class)->toArray());
        $types->where('value', 'motrice')->first()->push(['coef' => 1.8]);
        $types->where('value', 'voiture')->first()->push(['coef' => 1.5]);
        $types->where('value', 'automotrice')->first()->push(['coef' => 2]);
        $types->where('value', 'bus')->first()->push(['coef' => 1.2]);
        if ($search != null) {
            return $types->where('value', $search)->first()[$field ?? 'label'];
        } else {
            return $types;
        }
    }

    public function selectorTypeEnergy($search = null, $field = null)
    {
        $types = collect(Options::forEnum(RailwayEngineEnergyEnum::class)->toArray());
        $coefficients = [
            'diesel' => 1.5,
            'vapeur' => 1.2,
            'electrique' => 2.2,
            'hybride' => 2.5,
            'none' => 1,
        ];

        foreach ($coefficients as $value => $coef) {
            $types->where('value', $value)->first()->push(['coef' => $coef]);
        }

        if ($search != null) {
            return $types->where('value', $search)->first()[$field ?? 'label'];
        } else {
            return $types;
        }
    }
    public function selectorMoneyShop($search = null)
    {
        $types = collect(Options::forEnum(EngineMoneyEnum::class)->toArray());

        if ($search != null) {
            return $types->where('value', $search)->first()['label'];
        } else {
            return $types;
        }
    }

    public function selectorTypeMotor($search = null, $field = null)
    {
        $types = collect(Options::forEnum(EngineTechMotorEnum::class)->toArray());
        $coefficients = [
            'diesel' => 1.5,
            'electrique 1500V' => 1.8,
            'electrique 25000V' => 1.8,
            'electrique 1500V/25000V' => 1.8,
            'vapeur' => 1.2,
            'hybride' => 2.2,
            'autre' => 1,
        ];

        foreach ($coefficients as $value => $coef) {
            $types->where('value', $value)->first()->push(['coef' => $coef]);
        }

        if ($search != null) {
            return $types->where('value', $search)->first()[$field ?? 'label'];
        } else {
            return $types;
        }
    }
    public function selectorTypeMarchandise($search = null, $field = null)
    {
        $types = collect(Options::forEnum(EngineTechMarchEnum::class)->toArray());
        $coefficients = [
            'none' => 1,
            'passagers' => 1.5,
            'marchandises' => 1.2,
        ];

        foreach ($coefficients as $value => $coef) {
            $types->where('value', $value)->first()->push(['coef' => $coef]);
        }

        if ($search != null) {
            return $types->where('value', $search)->first()[$field ?? 'label'];
        } else {
            return $types;
        }
    }
}
