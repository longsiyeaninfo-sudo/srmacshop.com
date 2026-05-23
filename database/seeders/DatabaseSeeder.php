<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@srmacshop.com'],
          [
              'name' => 'SR Mac Admin',
         'password' => Hash::make('password'),
              'role' => 'admin',
             'email_verified_at' => now(),
        ]
        );

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            CouponSeeder::class,
            SettingSeeder::class,
            HomePromoCardSeeder::class,
        ]);
    }
}
