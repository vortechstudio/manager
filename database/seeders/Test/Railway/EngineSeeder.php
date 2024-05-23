<?php

namespace Database\Seeders\Test\Railway;

use App\Actions\Railway\EngineAction;
use App\Models\Railway\Engine\RailwayEngine;
use Illuminate\Database\Seeder;

class EngineSeeder extends Seeder
{
    public function run(): void
    {
        $this->s1();
        $this->s2();
    }

    public function s1()
    {
        $duration_maint_1 = (new EngineAction())->calcDurationMaintenance("Bo'Bo'", true, 2);
        $e1 = RailwayEngine::create([
            'uuid' => \Str::uuid(),
            'name' => 'Z 5100 2C',
            'type_transport' => 'other',
            'type_train' => 'automotrice',
            'type_energy' => 'electrique',
            'duration_maintenance' => $duration_maint_1,
            'active' => true,
            'in_shop' => false,
            'in_game' => true,
            'status' => 'beta',
        ]);
        $e1->technical()->create([
            'essieux' => "Bo'Bo'",
            'velocity' => 120,
            'motor' => 'electrique 1500v',
            'marchandise' => 'passagers',
            'nb_marchandise' => 240,
            'nb_wagon' => 2,
            'railway_engine_id' => $e1->id,
        ]);
        $e1->price()->create([
            'achat' => (new EngineAction())->calcTarifAchat(
                $e1->type_train->value,
                $e1->type_energy->value,
                $e1->technical->motor->value,
                $e1->technical->marchandise->value,
                (new EngineAction())->getDataCalcForEssieux($e1->technical->essieux, true, 2),
                2,
            ),
            'in_reduction' => false,
            'maintenance' => (new EngineAction())->calcPriceMaintenance(
                $e1->duration_maintenance->diffInMinutes(now()->startOfDay()),
                (new EngineAction())->getDataCalcForEssieux($e1->technical->essieux, true, 2),
            ),
            'location' => (new EngineAction())->calcPriceLocation((new EngineAction())->calcTarifAchat(
                $e1->type_train->value,
                $e1->type_energy->value,
                $e1->technical->motor->value,
                $e1->technical->marchandise->value,
                (new EngineAction())->getDataCalcForEssieux($e1->technical->essieux, true, 2),
                2,
            )),
            'railway_engine_id' => $e1->id,
        ]);
    }
    public function s2()
    {
        $duration_maint_1 = (new EngineAction())->calcDurationMaintenance("Bo'Bo'", true, 3);
        $e1 = RailwayEngine::create([
            'uuid' => \Str::uuid(),
            'name' => 'Z 5100 3C',
            'type_transport' => 'other',
            'type_train' => 'automotrice',
            'type_energy' => 'electrique',
            'duration_maintenance' => $duration_maint_1,
            'active' => true,
            'in_shop' => false,
            'in_game' => true,
            'status' => 'beta',
        ]);
        $e1->technical()->create([
            'essieux' => "Bo'Bo'",
            'velocity' => 120,
            'motor' => 'electrique 1500v',
            'marchandise' => 'passagers',
            'nb_marchandise' => 350,
            'nb_wagon' => 3,
            'railway_engine_id' => $e1->id,
        ]);
        $e1->price()->create([
            'achat' => (new EngineAction())->calcTarifAchat(
                $e1->type_train->value,
                $e1->type_energy->value,
                $e1->technical->motor->value,
                $e1->technical->marchandise->value,
                (new EngineAction())->getDataCalcForEssieux($e1->technical->essieux, true, 3),
                3,
            ),
            'in_reduction' => false,
            'maintenance' => (new EngineAction())->calcPriceMaintenance(
                $e1->duration_maintenance->diffInMinutes(now()->startOfDay()),
                (new EngineAction())->getDataCalcForEssieux($e1->technical->essieux, true, 3),
            ),
            'location' => (new EngineAction())->calcPriceLocation((new EngineAction())->calcTarifAchat(
                $e1->type_train->value,
                $e1->type_energy->value,
                $e1->technical->motor->value,
                $e1->technical->marchandise->value,
                (new EngineAction())->getDataCalcForEssieux($e1->technical->essieux, true, 3),
                3,
            )),
            'railway_engine_id' => $e1->id,
        ]);
    }
}
