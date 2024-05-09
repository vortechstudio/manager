<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Railway\SettingsSeeder;
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

        $this->call(MenuSeeder::class);
        $this->call(SettingsSeeder::class);

        if (config('app.env') == 'local') {
            $this->call(TestSeeder::class);
        } elseif (config('app.env') == 'staging') {
            $this->call(StagingSeeder::class);
        }
    }
}
