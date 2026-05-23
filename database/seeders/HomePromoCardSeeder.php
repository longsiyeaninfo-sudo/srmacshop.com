<?php

namespace Database\Seeders;

use App\Models\HomePromoCard;
use Illuminate\Database\Seeder;

class HomePromoCardSeeder extends Seeder
{
    /**
     * Seed two demo promo cards (Facebook + TikTok) so the
     * Computer Sales section on the homepage shows real content
     * on first load. Admin can edit/delete them via Filament.
     */
    public function run(): void
    {
        $cards = [
            [
                'platform'      => 'facebook',
                'image_path'    => null, // admin uploads via Filament; emoji fallback meanwhile
                'headline_en'   => '🔥 MacBook Pro M4 — Save $200 this week',
                'headline_km'   => '🔥 MacBook Pro M4 — សន្សំ $200 សប្តាហ៍នេះ',
                'headline_zh'   => '🔥 MacBook Pro M4 — 本周省 $200',
                'subtext_en'    => 'Official Apple warranty. Same-day delivery in Phnom Penh.',
                'subtext_km'    => 'ការធានា Apple ផ្លូវការ។ ដឹកជញ្ជូនក្នុងថ្ងៃនៅភ្នំពេញ។',
                'subtext_zh'    => 'Apple 官方保修。金边当日送达。',
                'link_url'      => 'https://facebook.com/srmacshop',
                'cta_label_en'  => 'View Post →',
                'cta_label_km'  => 'មើលប្រកាស →',
                'cta_label_zh'  => '查看帖子 →',
                'sort_order'    => 1,
                'is_active'     => true,
            ],
            [
                'platform'      => 'tiktok',
                'image_path'    => null,
                'headline_en'   => '⚡️ Unboxing: M4 MacBook Air vs Pro',
                'headline_km'   => '⚡️ បើកប្រអប់៖ M4 MacBook Air ប្រៀបធៀប Pro',
                'headline_zh'   => '⚡️ 开箱：M4 MacBook Air 对比 Pro',
                'subtext_en'    => 'Watch which one we recommend for students this year.',
                'subtext_km'    => 'មើលថាមួយណាដែលយើងណែនាំសម្រាប់សិស្សឆ្នាំនេះ។',
                'subtext_zh'    => '看看我们今年向学生推荐的型号。',
                'link_url'      => 'https://www.tiktok.com/@srmacshop',
                'cta_label_en'  => 'Watch on TikTok →',
                'cta_label_km'  => 'មើលលើ TikTok →',
                'cta_label_zh'  => '在 TikTok 上观看 →',
                'sort_order'    => 2,
                'is_active'     => true,
            ],
        ];

        foreach ($cards as $card) {
            // Idempotent: keyed by headline_en so re-seeding won't duplicate.
            HomePromoCard::updateOrCreate(
                ['headline_en' => $card['headline_en']],
                $card,
            );
        }
    }
}
