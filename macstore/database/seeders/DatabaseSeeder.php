<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductSpec;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if they don't exist
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
      $support = Role::firstOrCreate(['name' => 'support']);

        // Assign role to existing admin user
        $adminUser = User::where('email', 'admin@macstore.com')->first();
        if ($adminUser && !$adminUser->hasRole('super-admin')) {
            $adminUser->assignRole('super-admin');
        }

        // Create support user if doesn't exist
        $supportUser = User::firstOrCreate(
            ['email' => 'support@macstore.com'],
            ['name' => 'Support User', 'password' => bcrypt('password')]
        );
        if (!$supportUser->hasRole('support')) {
         $supportUser->assignRole('support');
        }

      // Create sample customers
        if (User::count() < 8) {
            User::factory(5)->create();
        }

        // Create categories
        $macbookAir = Category::firstOrCreate(
            ['slug' => 'macbook-air'],
            [
         'name' => ['en' => 'MacBook Air', 'km' => 'MacBook Air'],
              'description' => ['en' => 'Lightweight and powerful', 'km' => 'ស្រាលនិងមានថាមពល'],
                'is_active' => true,
              'sort_order' => 1,
            ]
     );

     $macbookPro14 = Category::firstOrCreate(
            ['slug' => 'macbook-pro-14'],
       [
                'name' => ['en' => 'MacBook Pro 14"', 'km' => 'MacBook Pro 14"'],
                'description' => ['en' => 'Pro performance in compact size', 'km' => 'ការអនុវត្តវិជ្ជាជីវៈក្នុងទំហំតូច'],
            'is_active' => true,
                'sort_order' => 2,
            ]
        );

        $macbookPro16 = Category::firstOrCreate(
            ['slug' => 'macbook-pro-16'],
        [
             'name' => ['en' => 'MacBook Pro 16"', 'km' => 'MacBook Pro 16"'],
                'description' => ['en' => 'Maximum power and screen size', 'km' => 'ថាមពលនិងទំហំអេក្រង់អតិបរមា'],
                'is_active' => true,
             'sort_order' => 3,
            ]
        );

      $refurbished = Category::firstOrCreate(
            ['slug' => 'refurbished'],
            [
                'name' => ['en' => 'Refurbished', 'km' => 'បានជួសជុល'],
                'description' => ['en' => 'Certified refurbished MacBooks', 'km' => 'MacBook ដែលបានជួសជុលដោយបញ្ជាក់'],
                'is_active' => true,
          'sort_order' => 4,
            ]
      );

        // Create MacBook Air M3
        $airM3 = Product::firstOrCreate(
          ['slug' => 'macbook-air-13-m3'],
        [
                'category_id' => $macbookAir->id,
                'name' => ['en' => 'MacBook Air 13" M3', 'km' => 'MacBook Air 13" M3'],
             'sku_prefix' => 'MBA-M3',
             'short_description' => ['en' => 'M3 chip, up to 18 hours battery', 'km' => 'បន្ទះ M3, ថ្មរហូតដល់ 18 ម៉ោង'],
             'description' => ['en' => 'The new MacBook Air with M3 chip delivers exceptional performance and all-day battery life.', 'km' => 'MacBook Air ថ្មីជាមួយបន្ទះ M3 ផ្តល់នូវការអនុវត្តពិសេសនិងថាមពលថ្មមួយថ្ងៃ។'],
           'base_price' => 1099,
            'condition' => 'new',
        'is_featured' => true,
                'is_active' => true,
            ]
    );

        // Variants
        ProductVariant::firstOrCreate(
      ['sku' => 'MBA-M3-8-256-MN'],
            [
        'product_id' => $airM3->id,
              'ram' => '8GB',
                'storage' => '256GB',
                'color' => 'Midnight',
                'price_modifier' => 0,
                'stock_quantity' => 15,
            ]
        );

        ProductVariant::firstOrCreate(
            ['sku' => 'MBA-M3-16-512-SG'],
            [
                'product_id' => $airM3->id,
                'ram' => '16GB',
                'storage' => '512GB',
              'color' => 'Space Gray',
                'price_modifier' => 300,
                'stock_quantity' => 10,
            ]
        );

      // Specs
        if ($airM3->specs()->count() === 0) {
            ProductSpec::create(['product_id' => $airM3->id, 'key' => 'processor', 'value' => ['en' => 'Apple M3 chip with 8-core CPU', 'km' => 'បន្ទះ Apple M3 ជាមួយ CPU 8 ស្នូល'], 'sort_order' => 1]);
            ProductSpec::create(['product_id' => $airM3->id, 'key' => 'display', 'value' => ['en' => '13.6-inch Liquid Retina display', 'km' => 'អេក្រង់ Liquid Retina 13.6 អ៊ីញ'], 'sort_order' => 2]);
            ProductSpec::create(['product_id' => $airM3->id, 'key' => 'battery', 'value' => ['en' => 'Up to 18 hours', 'km' => 'រហូតដល់ 18 ម៉ោង'], 'sort_order' => 3]);
        }

        // MacBook Pro 14" M4
        $pro14M4 = Product::firstOrCreate(
            ['slug' => 'macbook-pro-14-m4-pro'],
            [
        'category_id' => $macbookPro14->id,
          'name' => ['en' => 'MacBook Pro 14" M4 Pro', 'km' => 'MacBook Pro 14" M4 Pro'],
        'sku_prefix' => 'MBP14-M4',
             'short_description' => ['en' => 'M4 Pro chip, Liquid Retina XDR display', 'km' => 'បន្ទះ M4 Pro, អេក្រង់ Liquid Retina XDR'],
                'description' => ['en' => 'The most powerful 14-inch MacBook Pro ever.', 'km' => 'MacBook Pro 14 អ៊ីញដែលមានថាមពលបំផុត។'],
         'base_price' => 1999,
             'sale_price' => 1899,
                'condition' => 'new',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

     ProductVariant::firstOrCreate(
            ['sku' => 'MBP14-M4-16-512-SB'],
       [
            'product_id' => $pro14M4->id,
            'ram' => '16GB',
             'storage' => '512GB',
                'color' => 'Space Black',
                'price_modifier' => 0,
                'stock_quantity' => 8,
            ]
        );

        if ($pro14M4->specs()->count() === 0) {
            ProductSpec::create(['product_id' => $pro14M4->id, 'key' => 'processor', 'value' => ['en' => 'Apple M4 Pro chip with 12-core CPU', 'km' => 'បន្ទះ Apple M4 Pro ជាមួយ CPU 12 ស្នូល'], 'sort_order' => 1]);
            ProductSpec::create(['product_id' => $pro14M4->id, 'key' => 'display', 'value' => ['en' => '14.2-inch Liquid Retina XDR display', 'km' => 'អេក្រង់ Liquid Retina XDR 14.2 អ៊ីញ'], 'sort_order' => 2]);
            ProductSpec::create(['product_id' => $pro14M4->id, 'key' => 'battery', 'value' => ['en' => 'Up to 22 hours', 'km' => 'រហូតដល់ 22 ម៉ោង'], 'sort_order' => 3]);
     }

        // MacBook Pro 16" M4 Max
        $pro16M4 = Product::firstOrCreate(
         ['slug' => 'macbook-pro-16-m4-max'],
          [
                'category_id' => $macbookPro16->id,
                'name' => ['en' => 'MacBook Pro 16" M4 Max', 'km' => 'MacBook Pro 16" M4 Max'],
           'sku_prefix' => 'MBP16-M4',
                'short_description' => ['en' => 'M4 Max chip, ultimate performance', 'km' => 'បន្ទះ M4 Max, ការអនុវត្តចុងក្រោយ'],
                'description' => ['en' => 'The ultimate MacBook Pro with M4 Max chip.', 'km' => 'MacBook Pro ចុងក្រោយជាមួយបន្ទះ M4 Max។'],
        'base_price' => 2499,
                'condition' => 'new',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        ProductVariant::firstOrCreate(
         ['sku' => 'MBP16-M4-32-1TB-SB'],
            [
                'product_id' => $pro16M4->id,
                'ram' => '32GB',
           'storage' => '1TB',
             'color' => 'Space Black',
              'price_modifier' => 0,
             'stock_quantity' => 6,
            ]
      );

        if ($pro16M4->specs()->count() === 0) {
            ProductSpec::create(['product_id' => $pro16M4->id, 'key' => 'processor', 'value' => ['en' => 'Apple M4 Max chip with 16-core CPU', 'km' => 'បន្ទះ Apple M4 Max ជាមួយ CPU 16 ស្នូល'], 'sort_order' => 1]);
          ProductSpec::create(['product_id' => $pro16M4->id, 'key' => 'display', 'value' => ['en' => '16.2-inch Liquid Retina XDR display', 'km' => 'អេក្រង់ Liquid Retina XDR 16.2 អ៊ីញ'], 'sort_order' => 2]);
         ProductSpec::create(['product_id' => $pro16M4->id, 'key' => 'battery', 'value' => ['en' => 'Up to 24 hours', 'km' => 'រហូតដល់ 24 ម៉ោង'], 'sort_order' => 3]);
     }

        $this->command->info('Database seeded successfully!');
    }
}
