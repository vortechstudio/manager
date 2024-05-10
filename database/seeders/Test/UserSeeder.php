<?php

namespace Database\Seeders\Test;

use App\Models\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'admin@admin.com',
            'admin' => true,
        ]);

        User::factory(10)->create();

        foreach (User::all() as $user) {
            $user->profil()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
