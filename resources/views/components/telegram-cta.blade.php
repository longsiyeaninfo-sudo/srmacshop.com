@props(['storeInfo' => []])

@php
    $tgUrl = $storeInfo['telegram_url'] ?? null;
    $tgHandle = $storeInfo['telegram_channel'] ?? '@srmacshop';
    if (! $tgUrl) {
        $tgUrl = 'https://t.me/' . ltrim($tgHandle, '@');
    }
@endphp

<section>
    <div class="tg-cta-inner">
        <div class="tg-cta-paper-plane" aria-hidden="true">✈️</div>

        <div class="tg-cta-eyebrow"
             data-en="Telegram Channel"
             data-km="ឆានែលតេឡេក្រាម"
             data-zh="Telegram 频道">
            Telegram Channel
        </div>

        <h2 class="tg-cta-h"
            data-en="Join our Channel"
            data-km="ចូលរួមឆានែលរបស់យើង"
            data-zh="加入我们的频道">
            Join our Channel
        </h2>

        <p class="tg-cta-sub"
           data-en="Get exclusive deals, flash sales, and new arrivals — straight to your phone."
           data-km="ទទួលបានការផ្តល់ជូនពិសេស ការបញ្ចុះតម្លៃភ្លាមៗ និងផលិតផលថ្មី — ផ្ញើដល់ទូរស័ព្ទរបស់អ្នកដោយផ្ទាល់។"
           data-zh="独家优惠、限时抢购、新品上架 — 直送您的手机。">
            Get exclusive deals, flash sales, and new arrivals — straight to your phone.
        </p>

        <ul class="tg-cta-benefits">
            <li>
                <span class="tg-cta-check">✓</span>
                <span data-en="🔥 Daily flash deals (up to 30% off)"
                      data-km="🔥 ការផ្តល់ជូនពិសេសប្រចាំថ្ងៃ (បញ្ចុះតម្លៃរហូតដល់ 30%)"
                      data-zh="🔥 每日限时优惠（最高 30% 折扣）">
                    🔥 Daily flash deals (up to 30% off)
                </span>
            </li>
            <li>
                <span class="tg-cta-check">✓</span>
                <span data-en="📱 First access to new iPhones, iPads &amp; Macs"
                      data-km="📱 ទទួលបាន iPhone, iPad និង Mac ថ្មីៗមុនគេ"
                      data-zh="📱 抢先购买最新 iPhone、iPad 和 Mac">
                    📱 First access to new iPhones, iPads &amp; Macs
                </span>
            </li>
            <li>
                <span class="tg-cta-check">✓</span>
                <span data-en="🚚 Member-only same-day delivery slots"
                      data-km="🚚 ដឹកជញ្ជូនថ្ងៃនេះសម្រាប់សមាជិកប៉ុណ្ណោះ"
                      data-zh="🚚 会员专享当日配送">
                    🚚 Member-only same-day delivery slots
                </span>
            </li>
            <li>
                <span class="tg-cta-check">✓</span>
                <span data-en="💬 Direct support from our team"
                      data-km="💬 ការគាំទ្រដោយផ្ទាល់ពីក្រុមរបស់យើង"
                      data-zh="💬 团队直接支持">
                    💬 Direct support from our team
                </span>
            </li>
        </ul>

        <a href="{{ $tgUrl }}" target="_blank" rel="noopener" class="tg-cta-btn">
            <span class="tg-cta-btn-icon" aria-hidden="true">✈️</span>
            <span data-en="Join {{ $tgHandle }}"
                  data-km="ចូលរួម {{ $tgHandle }}"
                  data-zh="加入 {{ $tgHandle }}">
                Join {{ $tgHandle }}
            </span>
        </a>

        <div class="tg-cta-foot"
             data-en="Free forever · No spam · Unsubscribe anytime"
             data-km="ឥតគិតថ្លៃជារៀងរហូត · គ្មាន spam · បោះបង់ការជាវនៅពេលណាក៏បាន"
             data-zh="永久免费 · 无垃圾信息 · 随时退订">
            Free forever · No spam · Unsubscribe anytime
        </div>
    </div>
</section>
