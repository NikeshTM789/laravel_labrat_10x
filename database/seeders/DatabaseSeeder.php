<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => User::SUPREME]);
        Role::create(['name' => User::ADMIN]);
        Role::create(['name' => User::SELLER]);
        Role::create(['name' => User::USER]);

        (\App\Models\User::create([
                    'name' => 'Super Admin',
                    'email' => 'supreme@dev.com',
                    'password' => 'password',
                    'email_verified_at' => now()
                ]))->assignRole(User::SUPREME);

        (\App\Models\User::create([
                    'name' => 'Administrator',
                    'email' => 'admin@dev.com',
                    'password' => 'password',
                    'email_verified_at' => now()
                ]))->syncRoles(User::ADMIN);

        $this->call([
            UserTableSeeder::class,
            SellerTableSeeder::class,
            CategoryTableSeeder::class,
            ProductTableSeeder::class,
            CommentTableSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
