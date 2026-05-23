@props(['card'])

@php
    $img = $card->imageUrl();
    $isTikTok = $card->platform === 'tiktok';
    $cls = $isTikTok ? 'spc spc-tiktok' : 'spc spc-fb';
    $platformIcon = $isTikTok ? '🎵' : '📘';
    $platformLabel = $isTikTok ? 'TikTok' : 'Facebook';
@endphp

<a href="{{ $card->link_url }}" target="_blank" rel="noopener" class="{{ $cls }}">
    {{-- Platform header strip --}}
    <div class="spc-head">
        <div class="spc-head-l">
            <span class="spc-avatar">{{ $platformIcon }}</span>
            <div>
                <div class="spc-handle">SR MAC SHOP</div>
                <div class="spc-meta">
                    {{ $platformLabel }} ·
                    <span data-en="Sponsored" data-km="ផ្សព្វផ្សាយ" data-zh="赞助">Sponsored</span>
                </div>
            </div>
        </div>
        <span class="spc-platform-pill">{{ strtoupper($platformLabel) }}</span>
    </div>

    {{-- Media (1:1 for FB, 9:16 for TikTok) --}}
    <div class="spc-media">
        @if($img)
            <img src="{{ $img }}" alt="{{ $card->headline_en }}" loading="lazy">
        @else
            <div class="spc-media-fallback">{{ $platformIcon }}</div>
        @endif
        @if($isTikTok)
            <div class="spc-play">▶</div>
        @endif
    </div>

    {{-- Body --}}
    <div class="spc-body">
        <div class="spc-headline"
             data-en="{{ $card->headline_en }}"
             data-km="{{ $card->headline_km ?: $card->headline_en }}"
             data-zh="{{ $card->headline_zh ?: $card->headline_en }}">
            {{ $card->headline_en }}
        </div>
        @if($card->subtext_en)
            <div class="spc-sub"
                 data-en="{{ $card->subtext_en }}"
                 data-km="{{ $card->subtext_km ?: $card->subtext_en }}"
                 data-zh="{{ $card->subtext_zh ?: $card->subtext_en }}">
                {{ $card->subtext_en }}
            </div>
        @endif
    </div>

    {{-- Reactions row (FB) or stats (TikTok) — decorative --}}
    @if($isTikTok)
        <div class="spc-tt-stats">
            <span>❤️ 1.2K</span>
            <span>💬 84</span>
            <span>🔁 220</span>
        </div>
    @else
        <div class="spc-fb-reacts">
            <span>👍 ❤️ 😮</span>
            <span class="spc-fb-counts">
                231 · <span data-en="comments" data-km="មតិ" data-zh="评论">comments</span>
            </span>
        </div>
    @endif

    {{-- CTA --}}
    <div class="spc-cta">
        <span data-en="{{ $card->cta_label_en ?: 'View Post →' }}"
              data-km="{{ $card->cta_label_km ?: ($card->cta_label_en ?: 'View Post →') }}"
              data-zh="{{ $card->cta_label_zh ?: ($card->cta_label_en ?: 'View Post →') }}">
            {{ $card->cta_label_en ?: 'View Post →' }}
        </span>
    </div>
</a>
