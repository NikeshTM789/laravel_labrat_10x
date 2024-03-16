<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\{User, Product};

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_ids = User::role(User::USER)->pluck('id')->all();
        $product_ids = Product::pluck('id')->all();

        $i = 0;
        while ($i < 1000) {
            if (fake()->boolean()) {
                $timestamps = fake()->dateTime();
                $comment_id = DB::table('comments')->insertGetId([
                    'user_id' => $user_ids[array_rand($user_ids)],
                    'product_id' => $product_ids[array_rand($product_ids)],
                    'body' => fake()->text(100),
                    'created_at' => $timestamps,
                    'updated_at' => $timestamps,
                ]);
                if (fake()->boolean()) {
                    $no_of_comment_possibility = [3,5,10];
                    $no_of_comment = $no_of_comment_possibility[array_rand($no_of_comment_possibility)];
                    while ($no_of_comment > 0) {
                        DB::table('sub_comments')->insert([
                        'user_id' => $user_ids[array_rand($user_ids)],
                        'comment_id' => $comment_id,
                        'body' => fake()->text(100),
                        'created_at' => $timestamps,
                        'updated_at' => $timestamps,
                        ]);
                        $no_of_comment--;
                    }
                }
            }
            $i++;
        }
    }
}
