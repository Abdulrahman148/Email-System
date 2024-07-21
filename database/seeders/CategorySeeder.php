<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Insert in category table categories of email.
     */
    public function run(): void
    {
        Category::create(['name' => 'Important']);
        Category::create(['name' => 'Promotions']);
        Category::create(['name' => 'Updates']);
        Category::create(['name' => 'General']);
        // Add more categories as needed
    }
}
