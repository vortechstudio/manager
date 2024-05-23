<?php

namespace Database\Factories\User\Railway;

use App\Enums\Railway\Core\MvmTypeAmountEnum;
use App\Enums\Railway\Core\MvmTypeMvmEnum;
use App\Models\User\Railway\UserRailwayCompany;
use App\Models\User\Railway\UserRailwayHub;
use App\Models\User\Railway\UserRailwayLigne;
use App\Models\User\Railway\UserRailwayMouvement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Spatie\LaravelOptions\Options;

class UserRailwayMouvementFactory extends Factory
{
    protected $model = UserRailwayMouvement::class;

    public function definition(): array
    {
        $type_amount = $this->faker->randomElement(['charge', 'revenue']);
        $type_mvm = $type_amount == 'charge' ? $this->faker->randomElement(['achat_materiel', 'achat_hub', 'achat_ligne']) : $this->faker->randomElement(['vente_engine', 'vente_hub', 'vente_ligne']);
        return [
            'title' => $this->faker->word(),
            'amount' => $type_amount == 'charge' ? $this->faker->randomFloat(2, -500000, 0) : $this->faker->randomFloat(2, 1, 500000),
            'type_amount' => $type_amount,
            'type_mvm' => $type_mvm,
            'created_at' => $this->faker->dateTimeBetween(now()->subDays(4), now()),
            'updated_at' => $this->faker->dateTimeBetween(now()->subDays(4), now()),

            'user_railway_company_id' => UserRailwayCompany::all()->random()->id,
            'user_railway_hub_id' => UserRailwayHub::all()->random()->id,
            'user_railway_ligne_id' => UserRailwayLigne::all()->random()->id,
        ];
    }
}
