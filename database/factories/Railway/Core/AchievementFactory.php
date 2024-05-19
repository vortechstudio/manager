<?php

namespace Database\Factories\Railway\Core;

use App\Models\Railway\Core\Achievement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchievementFactory extends Factory
{
    protected $model = Achievement::class;

    public function definition(): array
    {
        return [
            'sector' => $this->faker->randomElement(['commun', 'infrastructure', 'finance']),
            'level' => $this->faker->randomElement(['bronze', 'argent', 'or']),
            'name' => $this->faker->text(100),
            'description' => $this->faker->text(),
            'action' => $this->faker->word(),
            'goal' => $this->faker->randomNumber(),
        ];
    }
}
