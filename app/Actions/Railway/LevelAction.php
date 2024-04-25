<?php

namespace App\Actions\Railway;

use App\Enums\Railway\Config\LevelRewardTypeEnum;
use App\Models\Railway\Config\RailwayLevel;
use App\Models\Railway\Config\RailwayLevelReward;

class LevelAction
{
    public function handle($niv_max = 50, $xp_start = 1250)
    {
        $this->generateRewards();
        $this->generateLevels($niv_max, $xp_start);
    }

    private function generateRewards(): void
    {
        $bases = collect();

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::ARGENT->name),
            'value' => intval(round(rand(1000, 9999), -2, PHP_ROUND_HALF_UP)),

        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::AUDIT_EXT->name),
            'value' => intval(round(rand(2, 10), 0, PHP_ROUND_HALF_UP)),
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::AUDIT_INT->name),
            'value' => intval(round(rand(2, 10), 0, PHP_ROUND_HALF_UP)),
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::ENGINE->name),
            'value' => 0,
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::ENGINE_R->name),
            'value' => 0,
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::IMPOT->name),
            'value' => intval(round(rand(1000, 10000), -2, PHP_ROUND_HALF_UP)),
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::RD_COAST->name),
            'value' => intval(round(rand(1000, 10000), -2, PHP_ROUND_HALF_UP)),
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::RD_RATE->name),
            'value' => round(random_float(0, 0.5), 2, PHP_ROUND_HALF_ODD),
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::SIMULATION->name),
            'value' => intval(round(rand(2, 10), 0, PHP_ROUND_HALF_UP)),
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::TPOINT->name),
            'value' => intval(round(rand(5, 20), 2, PHP_ROUND_HALF_UP)),
        ]);

        foreach (RailwayLevelReward::all() as $reward) {
            $reward->delete();
        }

        \DB::statement('ALTER TABLE `railway_level_rewards` AUTO_INCREMENT = 0;');

        foreach ($bases as $reward) {
            RailwayLevelReward::create([
                'name' => \Str::ucfirst($reward['type']),
                'type' => LevelRewardTypeEnum::tryFrom(\Str::lower($reward['type']))->value,
                'action' => 'reward_'.$reward['type'],
                'action_count' => $reward['value'],
            ]);
        }
    }

    private function generateLevels(mixed $niv_max, mixed $xp_start)
    {
        foreach (RailwayLevel::all() as $level) {
            $level->delete();
        }

        for ($i = 0; $i <= $niv_max; $i++) {
            RailwayLevel::create([
                'id' => $i,
                'exp_required' => $xp_start * ($i + config('railway.coef_level')),
                'railway_level_reward_id' => RailwayLevelReward::all()->random()->id,
            ]);
        }
    }
}
