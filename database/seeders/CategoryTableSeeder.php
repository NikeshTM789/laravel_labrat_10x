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
            ['uuid' => str()->uuid(), 'name' => 'electronics'],
            ['uuid' => str()->uuid(), 'name' => 'clothes'],
            ['uuid' => str()->uuid(), 'name' => 'toys'],
            ['uuid' => str()->uuid(), 'name' => 'kitchen appliances'],
            ['uuid' => str()->uuid(), 'name' => 'supermarket'],
            ['uuid' => str()->uuid(), 'name' => 'furnitures'],
            ['uuid' => str()->uuid(), 'name' => 'books'],
            ['uuid' => str()->uuid(), 'name' => 'footwear'],
            ['uuid' => str()->uuid(), 'name' => 'pet product'],
            ['uuid' => str()->uuid(), 'name' => 'food & breverage'],
            ['uuid' => str()->uuid(), 'name' => 'gaming'],
            ['uuid' => str()->uuid(), 'name' => 'mobiles & tablets'],
            ['uuid' => str()->uuid(), 'name' => 'auto & parts'],
            ['uuid' => str()->uuid(), 'name' => 'jewlery'],
            ['uuid' => str()->uuid(), 'name' => 'health'],
            ['uuid' => str()->uuid(), 'name' => 'infant'],
            ['uuid' => str()->uuid(), 'name' => 'home & garden'],
            ['uuid' => str()->uuid(), 'name' => 'fashion'],
        ]);
    }
}
