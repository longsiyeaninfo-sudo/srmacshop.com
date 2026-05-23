@props([
    'slug',
    'products',
    'eyebrowEn',
    'eyebrowKm' => null,
    'eyebrowZh' => null,
    'titleEn',
    'titleKm' => null,
    'titleZh' => null,
    'taglineEn' => null,
    'taglineKm' => null,
    'taglineZh' => null,
    'ctaEn' => 'Shop now →',
    'ctaKm' => 'ទិញឥឡូវ →',
    'ctaZh' => '立即购买 →',
    'background' => 'var(--bg2)',
    'emojiPlaceholder' => '📱',
])

<section class="shop-section cat-spotlight" style="background: {{ $background }}">
    <div class="inner">
        <div class="cat-spot-head">
            <div>
                <div class="sec-eyebrow"
                     data-en="{{ $eyebrowEn }}"
                     data-km="{{ $eyebrowKm ?: $eyebrowEn }}"
                     data-zh="{{ $eyebrowZh ?: $eyebrowEn }}">
                    {{ $eyebrowEn }}
                </div>
                <h2 class="sec-h"
                    data-en="{{ $titleEn }}"
                    data-km="{{ $titleKm ?: $titleEn }}"
                    data-zh="{{ $titleZh ?: $titleEn }}">
                    {{ $titleEn }}
                </h2>
                @if($taglineEn)
                    <p class="cat-spot-tagline"
                       data-en="{{ $taglineEn }}"
                       data-km="{{ $taglineKm ?: $taglineEn }}"
                       data-zh="{{ $taglineZh ?: $taglineEn }}">
                        {{ $taglineEn }}
                    </p>
                @endif
            </div>
            <a href="{{ route('shop') }}?category={{ $slug }}"
               class="btn btn-blue cat-spot-cta"
               data-en="{{ $ctaEn }}"
               data-km="{{ $ctaKm }}"
               data-zh="{{ $ctaZh }}">
                {{ $ctaEn }}
            </a>
        </div>

        @if($products->isEmpty())
            <div class="cat-spot-empty">
                <div class="cat-spot-empty-emoji" aria-hidden="true">{{ $emojiPlaceholder }}</div>
                <div class="cat-spot-empty-title"
                     data-en="Coming soon"
                     data-km="នឹងមកដល់ឆាប់ៗ"
                     data-zh="即将推出">
                    Coming soon
                </div>
                <p class="cat-spot-empty-sub"
                   data-en="We're stocking up. Join our Telegram channel to be the first to know."
                   data-km="យើងកំពុងបន្ថែមស្តុក។ ចូលរួមឆានែលតេឡេក្រាមរបស់យើងដើម្បីដឹងមុនគេ។"
                   data-zh="我们正在补货。加入我们的 Telegram 频道，第一时间获取消息。">
                    We're stocking up. Join our Telegram channel to be the first to know.
                </p>
                <a href="#telegram-cta" class="btn btn-blue"
                   data-en="Notify me"
                   data-km="ជូនដំណឹងខ្ញុំ"
                   data-zh="通知我">
                    Notify me
                </a>
            </div>
        @else
            <div class="pgrid" style="margin-top:20px">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </div>
</section>
