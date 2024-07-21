<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keyword;
use App\Models\Category;

class KeywordSeeder extends Seeder
{
    /**
     * insert the keywords and category associated to category table
     */
    public function run(): void
    {
        $category = Category::all();

        // Assuming categories with IDs 1, 2, and 3 exist
        Keyword::create(['keyword' => 'urgent', 'category_id' => $category[0]['id']]);
        Keyword::create(['keyword' => 'sale', 'category_id' => $category[1]['id']]);
        Keyword::create(['keyword' => 'newsletter', 'category_id' => $category[2]['id']]);
        Keyword::create(['keyword' => 'general', 'category_id' => $category[3]['id']]);
        // Add more keywords as needed
    }
}
