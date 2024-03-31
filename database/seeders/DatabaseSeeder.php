<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\Config\ServiceStatusEnum;
use App\Enums\Config\ServiceTypeEnum;
use App\Models\Config\Service;
use App\Models\Social\Cercle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Service::create([
            'name' => 'Accès de base',
            'type' => ServiceTypeEnum::PLATEFORME,
            'description' => 'Accès de base au plateforme Vortech Studio',
            'status' => ServiceStatusEnum::PRODUCTION,
            'url' => '//account.'.config('api.domain'),
        ]);

        Cercle::create([
            'name' => 'Vortech Studio',
        ]);
        Cercle::create([
            'name' => 'Vortech Lab',
        ]);
        Cercle::create([
            'name' => 'Railway Manager',
        ]);

        $this->call(MenuSeeder::class);

        if (config('app.env') == 'local' || config('app.env') == 'testing') {
            $this->call(TestSeeder::class);
        }
    }
}
