<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Section;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Category::factory()
            ->count(10)
            ->hasProducts(20)
            ->create();

        Section::factory()
            ->count(10)
            ->hasTables(10)
            ->create();
    }
}