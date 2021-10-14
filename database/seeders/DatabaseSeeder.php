<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::truncate();
        // \App\Models\Brand::truncate();
        // \App\Models\Product::truncate();
        // \App\Models\Category::truncate();
        // \App\Models\SubCategory::truncate();

        \App\Models\Category::factory(15)->create();
        \App\Models\SubCategory::factory(13)->create();
        \App\Models\User::factory(1000)->create();
        \App\Models\Brand::factory(25)->create();
        \App\Models\Product::factory(1000)->create();
    }
}
