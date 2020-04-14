<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => Str::random(10),
            'description' => Str::random(10),
            'slug' => Str::random(5),
            'status' => 1,
            'category_id' => 1
        ]);
    }
}
