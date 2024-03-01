<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_ids = DB::table('users')->pluck('id')->all();
        $category_ids = DB::table('categories')->pluck('id')->all();

        $i = 0;
        while ($i < 1500) {
            $user_id = $user_ids[array_rand($user_ids)];

            shuffle($category_ids);
            $_3_random_category_ids = array_slice($category_ids, 0, 5);

            \App\Models\Product::create([
                'name' => fake()->catchPhrase(),
                'quantity' => fake()->randomDigitNotNull(),
                'price' => fake()->numberBetween(800,8000),
                'discount' => fake()->numberBetween(100,200),
                'featured' => fake()->boolean(),
                'details' => fake()->text(500),
                'added_by' => $user_id,
            ])->categories()->attach($_3_random_category_ids);

            $i++;
        }
    }
}
