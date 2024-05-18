<?php

namespace Database\Seeders\Railway;

use App\Models\Railway\Config\RailwaySetting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        if (! RailwaySetting::where('name', 'like', '%price_electricity%')->exists()) {
            \DB::connection('railway')->table('railway_settings')->insert([
                'name' => 'price_electricity',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%price_diesel%')->exists()) {
            \DB::connection('railway')->table('railway_settings')->insert([
                'name' => 'price_diesel',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%price_parking%')->exists()) {
            \DB::connection('railway')->table('railway_settings')->insert([
                'name' => 'price_parking',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%price_kilometer%')->exists()) {
            \DB::connection('railway')->table('railway_settings')->insert([
                'name' => 'price_kilometer',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%start_argent%')->exists()) {
            \DB::connection('railway')->table('railway_settings')->insert([
                'name' => 'start_argent',
                'value' => 3000000,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%start_tpoint%')->exists()) {
            \DB::connection('railway')->table('railway_settings')->insert([
                'name' => 'start_tpoint',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%start_research%')->exists()) {
            \DB::connection('railway')->table('railway_settings')->insert([
                'name' => 'start_research',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%exchange_tpoint%')->exists()) {
            \DB::connection('railway')->table('railway_settings')->insert([
                'name' => 'exchange_tpoint',
                'value' => 0,
            ]);
        }
    }
}
