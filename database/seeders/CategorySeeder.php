<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['slug' => 'smartphones',  'name' => 'Smartphones',    'sort_order' => 1],
            ['slug' => 'tablets-ipad', 'name' => 'Tablets / iPad', 'sort_order' => 2],
            ['slug' => 'computers',    'name' => 'Computers',      'sort_order' => 3],
            ['slug' => 'macbook-air',  'name' => 'MacBook Air',    'sort_order' => 4],
            ['slug' => 'macbook-pro',  'name' => 'MacBook Pro',    'sort_order' => 5],
            ['slug' => 'accessories',  'name' => 'Accessories',    'sort_order' => 6],
            ['slug' => 'protection',   'name' => 'Protection',     'sort_order' => 7],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
