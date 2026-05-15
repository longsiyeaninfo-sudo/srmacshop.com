<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
         'shop_phone' => '+855 98 33 47 55',
      'shop_whatsapp' => '+855 98 33 47 55',
            'shop_telegram' => 'srmacshop',
          'shop_address' => 'Borey Pibhu Thmey Kambol III, Sangkat Kambol, Phnom Penh',
            'shop_address_km' => 'បុរីពិភពថ្មីកំបូល III ភូមិថ្មដា សង្កាត់កំបូល ខណ្ឌកំបូល ភ្នំពេញ',
        'shop_hours_en' => 'Mon–Sun: 8AM – 8PM',
            'shop_hours_km' => 'ច័ន្ទ–អាទិត្យ: ៨ – ២០ម៉ោង',
       'shop_lat' => '11.55949976721228',
            'shop_lng' => '104.89155303686857',
        'shop_founded' => '2018',
            'shop_tagline_en' => 'Think Different. Buy Smarter.',
        'shop_tagline_km' => 'គិតខុសគេ។ ទិញឆ្លាតជាង។',
        ];

     foreach ($settings as $key => $value) {
            Setting::put($key, $value);
        }
    }
}
