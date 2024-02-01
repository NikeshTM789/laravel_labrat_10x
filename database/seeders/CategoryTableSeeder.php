<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['uuid' => str()->uuid(), 'name' => 'Electronics'],
            ['uuid' => str()->uuid(), 'name' => 'Clothes'],
            ['uuid' => str()->uuid(), 'name' => 'Toys'],
            ['uuid' => str()->uuid(), 'name' => 'Kitchen Products'],
            ['uuid' => str()->uuid(), 'name' => 'Supermarket'],
        ]);
    }
}
