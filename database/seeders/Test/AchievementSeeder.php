<?php

namespace Database\Seeders\Test;

use App\Models\Railway\Core\Achievement;
use App\Models\Railway\Core\AchieveReward;
use App\Models\User\Railway\UserRailwayAchievement;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        Achievement::factory(rand(50, 150))->create();
        foreach (Achievement::all() as $achievement) {
            $reward = AchieveReward::factory()->create();
            $reward->achievements()->attach($reward->id);
        }

        foreach (User::all() as $user) {
            if($user->services()->where('service_id', 2)->first()->exists()) {
                for($i=0; $i <= count(Achievement::all()); $i++) {
                    $achievement = $user->railway_achievements()->create([
                        'achievement_id' => Achievement::inRandomOrder()->first()->id,
                        'user_id' => $user->id,
                        'created_at' => now()->subDays(rand(0,90)),
                        'updated_at' => now()->subDays(rand(0,90)),
                    ]);

                    $user->railway_rewards()->create([
                        'user_id' => $user->id,
                        'model' => AchieveReward::class,
                        'model_id' => $achievement->achievement->rewards()->first()->id
                    ]);
                }
            }
        }
    }
}
