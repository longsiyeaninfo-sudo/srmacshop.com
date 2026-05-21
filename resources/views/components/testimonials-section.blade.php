@props(['variant' => 'light'])

@php
    $items = \App\Models\Setting::get('testimonials', []) ?: [];
    if (empty($items)) { return; }
    $bg = $variant === 'dark' ? '#0a0a0a' : 'var(--bg)';
    $textColor = $variant === 'dark' ? '#fff' : 'var(--text)';
    $cardBg = $variant === 'dark' ? 'rgba(255,255,255,.04)' : 'var(--card)';
    $cardBorder = $variant === 'dark' ? 'rgba(255,255,255,.08)' : 'var(--hairline)';
    $quoteColor = $variant === 'dark' ? 'rgba(255,255,255,.85)' : 'var(--text)';
    $metaColor = $variant === 'dark' ? 'rgba(255,255,255,.55)' : 'var(--text2)';
@endphp

<style>
.tn-section{padding:96px 1.5rem;background:{{ $bg }};color:{{ $textColor }}}
.tn-inner{max-width:1200px;margin:0 auto}
.tn-head{text-align:center;margin-bottom:48px}
.tn-eyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:var(--blue);margin-bottom:.5rem}
.tn-h{font-size:clamp(1.8rem,3.5vw,2.6rem);font-weight:700;letter-spacing:-.025em;color:{{ $textColor }}}
.tn-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px}
.tn-card{background:{{ $cardBg }};border:1px solid {{ $cardBorder }};border-radius:var(--radius-lg);padding:28px;display:flex;flex-direction:column;gap:14px;transition:transform .3s var(--ease),box-shadow .3s var(--ease)}
.tn-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
.tn-stars{display:flex;gap:2px;color:#ff9500;font-size:14px;line-height:1}
.tn-quote{font-size:15px;line-height:1.55;color:{{ $quoteColor }};letter-spacing:-.005em;flex:1}
.tn-meta{display:flex;align-items:center;gap:10px;margin-top:auto;padding-top:14px;border-top:1px solid {{ $cardBorder }}}
.tn-avatar{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg, #007aff, #af52de);color:#fff;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:600;flex-shrink:0}
.tn-name{font-size:13px;font-weight:600;color:{{ $textColor }};line-height:1.2}
.tn-role{font-size:12px;color:{{ $metaColor }};line-height:1.2;margin-top:2px}
</style>

<section class="tn-section reveal">
    <div class="tn-inner">
        <div class="tn-head">
            <div class="tn-eyebrow" data-en="Testimonials" data-km="មតិកែលម្អ">Testimonials</div>
            <h2 class="tn-h" data-en="Loved by customers across Cambodia" data-km="ស្រឡាញ់ដោយអតិថិជនទូទាំងកម្ពុជា">Loved by customers across Cambodia</h2>
        </div>
        <div class="tn-grid">
            @foreach($items as $t)
                @php
                    $name = trim($t['name'] ?? '');
                    $initial = $name !== '' ? strtoupper(mb_substr($name, 0, 1)) : '★';
                    $rating = max(1, min(5, (int) ($t['rating'] ?? 5)));
                @endphp
                <div class="tn-card">
                    <div class="tn-stars">
                        @for($i = 0; $i < $rating; $i++)★@endfor
                    </div>
                    <p class="tn-quote">"{{ $t['quote'] ?? '' }}"</p>
                    <div class="tn-meta">
                        <div class="tn-avatar">{{ $initial }}</div>
                        <div>
                            <div class="tn-name">{{ $name ?: 'Anonymous' }}</div>
                            @if(!empty($t['role']))
                                <div class="tn-role">{{ $t['role'] }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
