<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::create([
            'category_name' => 'ゲーム',
        ]);
        Category::create([
            'category_name' => '食事',
        ]);
        Category::create([
            'category_name' => '旅行',
        ]);
        Category::create([
            'category_name' => 'スポーツ',
        ]);
        Category::create([
            'category_name' => '音楽',
        ]);

    }
}
