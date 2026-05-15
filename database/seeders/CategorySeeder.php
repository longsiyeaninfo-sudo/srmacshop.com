<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
     $categories = [
            ['slug' => 'macbook-air', 'name' => 'MacBook Air'],
            ['slug' => 'macbook-pro', 'name' => 'MacBook Pro'],
            ['slug' => 'accessories', 'name' => 'Accessories'],
            ['slug' => 'protection', 'name' => 'Protection'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
