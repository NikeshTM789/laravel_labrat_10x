<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\{User, Product};

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seller_ids = User::role(User::SELLER)->pluck('id')->all();
        $category_ids = DB::table('categories')->pluck('id')->all();

        $i = 0;
        while ($i < 1500) {
            $user_id = $seller_ids[array_rand($seller_ids)];

            shuffle($category_ids);
            $_3_random_category_ids = array_slice($category_ids, 0, 5);

            $datetTime = fake()->dateTime();
            Product::create([
                'name' => fake()->catchPhrase(),
                'quantity' => fake()->randomDigitNotNull(),
                'price' => fake()->numberBetween(800,8000),
                'discount' => fake()->numberBetween(0,200),
                'featured' => fake()->boolean(),
                'details' => fake()->text(500),
                'added_by' => $user_id,
                'created_at' => $datetTime,
                'updated_at' => $datetTime,
            ])->categories()->attach($_3_random_category_ids);

            $i++;
        }
    }
}
