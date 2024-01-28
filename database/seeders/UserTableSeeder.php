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
        $password = bcrypt('password');

        $i = 0;
        while ($i < 20) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => $password,
                'email_verified_at' => fake()->datetime()
            ])->assignRole(User::USER);
            $i++;
        }
    }
}
