<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $i = 0;
        while ($i < 100) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => 'password',
                'email_verified_at' => fake()->datetime()
            ])->assignRole(User::USER);
            $i++;
        }
    }
}
