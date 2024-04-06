<?php

namespace App\Actions\Railway;

class EngineSelectAction
{
    public function selectorTypeTrain($search = null, $field = null)
    {
        $arr = collect();
        $arr->push([
            'id' => 'motrice',
            'value' => 'Motrice',
            'coef' => 1.8,
        ]);
        $arr->push([
            'id' => 'voiture',
            'value' => 'Voiture',
            'coef' => 1.5,
        ]);
        $arr->push([
            'id' => 'automotrice',
            'value' => 'Automotrice',
            'coef' => 2,
        ]);
        $arr->push([
            'id' => 'bus',
            'value' => 'Bus',
            'coef' => 1.2,
        ]);

        if ($search != null) {
            return $arr->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $arr;
        }
    }

    public function selectorTypeEnergy($search = null, $field = null)
    {
        $arr = collect();
        $arr->push([
            'id' => 'diesel',
            'value' => 'Diesel',
            'coef' => 1.5,
        ]);
        $arr->push([
            'id' => 'vapeur',
            'value' => 'Vapeur',
            'coef' => 1.2,
        ]);
        $arr->push([
            'id' => 'electrique',
            'value' => 'Electrique',
            'coef' => 2.2,
        ]);
        $arr->push([
            'id' => 'hybride',
            'value' => 'Hybride',
            'coef' => 2.5,
        ]);
        $arr->push([
            'id' => 'none',
            'value' => 'Aucun',
            'coef' => 1,
        ]);

        if ($search != null) {
            return $arr->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $arr;
        }
    }

    public function selectorMoneyShop($search = null)
    {
        $argc = collect();
        $argc->push([
            'id' => 'tpoint',
            'value' => 'T Point',
        ]);
        $argc->push([
            'id' => 'argent',
            'value' => 'Monnaie Virtuel',
        ]);
        $argc->push([
            'id' => 'euro',
            'value' => 'Monnaie Réel',
        ]);

        if ($search != null) {
            return $argc->where('id', $search)->first()['value'];
        } else {
            return $argc;
        }
    }

    public function selectorTypeMotor($search = null, $field = null)
    {
        $argc = collect();

        $argc->push([
            'id' => 'diesel',
            'value' => 'Diesel',
            'coef' => 1.5,
        ]);

        $argc->push([
            'id' => 'electrique 1500V',
            'value' => 'Electrique 1500V',
            'coef' => 1.8,
        ]);

        $argc->push([
            'id' => 'electrique 25Kv',
            'value' => 'Electrique 25Kv',
            'coef' => 1.8,
        ]);

        $argc->push([
            'id' => 'electrique 1500v/25Kv',
            'value' => 'Electrique 1500V/25Kv',
            'coef' => 1.8,
        ]);

        $argc->push([
            'id' => 'vapeur',
            'value' => 'Vapeur',
            'coef' => 1.2,
        ]);

        $argc->push([
            'id' => 'hybride',
            'value' => 'Hybride',
            'coef' => 2.2,
        ]);

        $argc->push([
            'id' => 'autre',
            'value' => 'Autre',
            'coef' => 1,
        ]);

        if ($search != null) {
            return $argc->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $argc;
        }
    }

    public function selectorTypeMarchandise($search = null, $field = null)
    {
        $argc = collect();

        $argc->push([
            'id' => 'none',
            'value' => 'Aucun',
            'coef' => 1,
        ]);

        $argc->push([
            'id' => 'passagers',
            'value' => 'Passagers',
            'coef' => 1.5,
        ]);

        $argc->push([
            'id' => 'marchandises',
            'value' => 'Marchandises',
            'coef' => 1.2,
        ]);

        if ($search != null) {
            return $argc->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $argc;
        }
    }
}
