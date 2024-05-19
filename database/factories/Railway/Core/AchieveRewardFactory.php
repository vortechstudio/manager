<?php

namespace Database\Factories\Railway\Core;

use App\Models\Railway\Core\AchieveReward;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchieveRewardFactory extends Factory
{
    protected $model = AchieveReward::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(50),
            'description' => $this->faker->text(),
            'type_reward' => $this->faker->randomElement(['argent']),
            'amount_reward' => round($this->faker->randomNumber(), 5, PHP_ROUND_HALF_DOWN),
        ];
    }
}
