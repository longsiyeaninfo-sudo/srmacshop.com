<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
      $coupons = [
          [
              'code' => 'SAVE10',
              'type' => 'percent',
              'value' => 10,
                'min_subtotal' => 0,
            'max_uses' => 0,
            'is_active' => true,
       ],
            [
                'code' => 'MAC50',
                'type' => 'fixed',
           'value' => 5000,
         'min_subtotal' => 50000,
            'max_uses' => 100,
              'is_active' => true,
       ],
        ];

        foreach ($coupons as $c) {
            Coupon::updateOrCreate(['code' => $c['code']], $c);
        }
    }
}
