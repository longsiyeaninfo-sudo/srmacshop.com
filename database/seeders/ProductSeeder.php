<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Placeholder seeder. Replace with the prototype's PRODUCTS array
 * (srmacshop-full_13.html, around line 1273) once the prototype is in the repo.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
     $air = Category::where('slug', 'macbook-air')->first();
        $pro = Category::where('slug', 'macbook-pro')->first();
        $acc = Category::where('slug', 'accessories')->first();

        $products = [
            [
              'name' => 'MacBook Air 13" M3',
     'spec' => 'M3 chip, 8GB / 256GB',
            'price' => 109900,
           'emoji' => '💻',
                'category_id' => $air?->id,
          'stock' => 12,
           'badge' => 'new',
            'description' => "Apple's thinnest MacBook with M3 power. Silent, fanless, all-day battery.",
         'warranty' => '2 years',
                'is_active' => true,
            'sort_order' => 1,
        ],
        [
         'name' => 'MacBook Pro 14" M3 Pro',
              'spec' => 'M3 Pro, 18GB / 512GB',
          'price' => 249900,
          'emoji' => '💻',
           'category_id' => $pro?->id,
           'stock' => 6,
          'badge' => 'hot',
              'description' => 'Pro-level performance with the M3 Pro chip and Liquid Retina XDR display.',
           'warranty' => '2 years',
        'is_active' => true,
            'sort_order' => 2,
            ],
     [
                'name' => 'MacBook Pro 16" M3 Max',
                'spec' => 'M3 Max, 36GB / 1TB',
                'price' => 399900,
              'emoji' => '💻',
                'category_id' => $pro?->id,
                'stock' => 3,
                'badge' => 'hot',
                'description' => 'The most powerful MacBook ever. Built for creators and developers.',
                'warranty' => '2 years',
              'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'USB-C Multiport Adapter',
              'spec' => 'HDMI + USB-A + USB-C',
                'price' => 4900,
                'emoji' => '🔌',
                'category_id' => $acc?->id,
                'stock' => 50,
           'is_active' => true,
            'sort_order' => 10,
            ],
        ];

        foreach ($products as $p) {
          $p['slug'] = Str::slug($p['name']);
          Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
