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

        (\App\Models\User::factory()->create([
                    'name' => 'Super Admin',
                    'email' => 'supreme@dev.com',
                    'password' => $password
                ]))->assignRole(User::SUPREME);

        (\App\Models\User::factory()->create([
                    'name' => 'Administrator',
                    'email' => 'admin@dev.com',
                    'password' => $password
                ]))->syncRoles(User::ADMIN);

        (\App\Models\User::factory()->create([
                    'name' => 'User',
                    'email' => 'user@dev.com',
                    'password' => $password
                ]))->assignRole(User::USER);
    }
}
