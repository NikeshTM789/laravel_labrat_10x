<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SellerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $i = 0;
        while ($i < 25) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => 'password',
                'email_verified_at' => fake()->datetime()
            ])->assignRole(User::SELLER);
            $i++;
        }
    }
}
