<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;


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
