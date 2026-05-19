@extends('layouts.storefront')

@section('title', 'Compare MacBooks — SR MAC SHOP')
@section('description', 'Compare MacBook specs side by side at SR MAC SHOP Cambodia.')

@section('content')
<style>
.cmp-wrap{max-width:1200px;margin:0 auto;padding:var(--space-8) var(--space-6) var(--space-16)}
.cmp-hero{text-align:center;margin-bottom:var(--space-8)}
.cmp-hero .eyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--blue);margin-bottom:var(--space-2)}
.cmp-hero h1{font-size:clamp(1.8rem,4vw,2.6rem);font-weight:700;letter-spacing:-.025em;margin-bottom:var(--space-2)}
.cmp-hero p{color:var(--text2);font-size:14px}

.cmp-empty{text-align:center;padding:var(--space-16) var(--space-4);color:var(--text2)}
.cmp-empty .emoji{font-size:48px;margin-bottom:var(--space-3)}
.cmp-empty a{color:var(--blue);font-weight:600}

.cmp-table{display:grid;gap:1px;background:var(--hairline);border-radius:var(--radius-lg);overflow:hidden;border:1px solid var(--hairline)}
.cmp-table > *{background:var(--card)}
.cmp-row{display:grid;align-items:stretch}
.cmp-row.head{grid-template-columns:160px repeat(var(--cols, 2), 1fr)}
.cmp-row.spec{grid-template-columns:160px repeat(var(--cols, 2), 1fr)}

.cmp-prod{padding:var(--space-5);display:flex;flex-direction:column;align-items:center;gap:var(--space-2);text-align:center}
.cmp-prod-img{width:100%;height:140px;background:var(--bg);border-radius:var(--radius);display:flex;align-items:center;justify-content:center;font-size:48px;overflow:hidden}
.cmp-prod-img img{width:100%;height:100%;object-fit:cover}
.cmp-prod-cat{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--blue)}
.cmp-prod-name{font-size:14px;font-weight:600;letter-spacing:-.01em;line-height:1.3}
.cmp-prod-price{font-size:20px;font-weight:700;letter-spacing:-.02em;margin-top:auto}
.cmp-prod-buy{display:inline-flex;align-items:center;gap:6px;background:var(--blue);color:#fff;border-radius:var(--radius-pill);padding:8px 18px;font-size:12px;font-weight:600;text-decoration:none;transition:background .15s var(--ease)}
.cmp-prod-buy:hover{background:var(--blue-h)}

.cmp-label{padding:var(--space-3) var(--space-4);font-size:12px;font-weight:600;color:var(--text2);text-transform:uppercase;letter-spacing:.5px;background:var(--bg)!important;display:flex;align-items:center}
.cmp-val{padding:var(--space-3) var(--space-4);font-size:14px;color:var(--text);display:flex;align-items:center}
.cmp-val.empty{color:var(--text3)}
.cmp-stock-ok{color:#1A7F3C;font-weight:600}
.cmp-stock-low{color:#C44B00;font-weight:600}
.cmp-stock-out{color:var(--red);font-weight:600}
[data-theme="dark"] .cmp-stock-ok{color:#30D158}
[data-theme="dark"] .cmp-stock-low{color:#FF9F0A}

.cmp-back{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--blue);font-weight:600;margin-bottom:var(--space-5);text-decoration:none}
.cmp-back:hover{text-decoration:underline}

@media (max-width: 720px){
  .cmp-row.head,.cmp-row.spec{grid-template-columns:110px repeat(var(--cols, 2), 1fr)}
  .cmp-prod{padding:var(--space-3)}
  .cmp-prod-img{height:90px;font-size:32px}
  .cmp-prod-name{font-size:12px}
  .cmp-prod-price{font-size:15px}
  .cmp-label{padding:var(--space-2) var(--space-3);font-size:10px}
  .cmp-val{padding:var(--space-2) var(--space-3);font-size:12px}
}
</style>

<div class="cmp-wrap">
    <a href="{{ route('shop') }}" class="cmp-back">← <span data-en="Back to shop" data-km="ត្រឡប់ទៅហាង">Back to shop</span></a>

    <div class="cmp-hero">
        <div class="eyebrow" data-en="Compare" data-km="ប្រៀបធៀប">Compare</div>
        <h1 data-en="Side-by-side spec comparison" data-km="ប្រៀបធៀបលក្ខណៈពិសេស">Side-by-side spec comparison</h1>
        <p data-en="Pick the MacBook that fits you best." data-km="ជ្រើសរើស MacBook ដែលសមនឹងអ្នកបំផុត។">Pick the MacBook that fits you best.</p>
    </div>

    @if($products->isEmpty())
        <div class="cmp-empty">
            <div class="emoji">🔍</div>
            <p data-en="No products to compare." data-km="មិនមានផលិតផលត្រូវប្រៀបធៀប។">No products to compare.</p>
            <p style="margin-top:8px"><a href="{{ route('shop') }}" data-en="Browse the catalog →" data-km="មើលបញ្ជី →">Browse the catalog →</a></p>
        </div>
    @else
        @php $cols = $products->count(); @endphp
        <div class="cmp-table" style="--cols:{{ $cols }}">
            {{-- Products header row --}}
            <div class="cmp-row head">
                <div class="cmp-label" data-en="Product" data-km="ផលិតផល">Product</div>
                @foreach($products as $p)
                    @php $img = $p->getFirstMediaUrl('gallery'); @endphp
                    <div class="cmp-prod">
                        <div class="cmp-prod-img">
                            @if($img)
                                <img src="{{ $img }}" alt="{{ $p->name }}">
                            @else
                                <span>{{ $p->emoji ?: '💻' }}</span>
                            @endif
                        </div>
                        <div class="cmp-prod-cat">{{ $p->category?->name }}</div>
                        <a href="{{ route('product', $p->slug) }}" style="text-decoration:none;color:inherit">
                            <div class="cmp-prod-name">{{ $p->name }}</div>
                        </a>
                        <div class="cmp-prod-price">${{ number_format($p->price / 100, 0) }}</div>
                        <a href="{{ route('product', $p->slug) }}" class="cmp-prod-buy" data-en="View →" data-km="មើល →">View →</a>
                    </div>
                @endforeach
            </div>

            @php
                $rows = [
                    ['label' => 'Specs', 'label_km' => 'លក្ខណៈពិសេស', 'field' => 'spec'],
                    ['label' => 'Warranty', 'label_km' => 'ការធានា', 'field' => 'warranty'],
                    ['label' => 'Color', 'label_km' => 'ពណ៌', 'field' => 'color'],
                    ['label' => 'Weight', 'label_km' => 'ទម្ងន់', 'field' => 'weight'],
                ];
            @endphp

            @foreach($rows as $row)
                <div class="cmp-row spec">
                    <div class="cmp-label" data-en="{{ $row['label'] }}" data-km="{{ $row['label_km'] }}">{{ $row['label'] }}</div>
                    @foreach($products as $p)
                        @php $val = $p->{$row['field']}; @endphp
                        <div class="cmp-val {{ $val ? '' : 'empty' }}">{{ $val ?: '—' }}</div>
                    @endforeach
                </div>
            @endforeach

            {{-- Stock row --}}
            <div class="cmp-row spec">
                <div class="cmp-label" data-en="Stock" data-km="ស្តុក">Stock</div>
                @foreach($products as $p)
                    <div class="cmp-val">
                        @if($p->stock > 5)
                            <span class="cmp-stock-ok">● In stock</span>
                        @elseif($p->stock > 0)
                            <span class="cmp-stock-low">● Only {{ $p->stock }} left</span>
                        @else
                            <span class="cmp-stock-out">● Out of stock</span>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Category row --}}
            <div class="cmp-row spec">
                <div class="cmp-label" data-en="Category" data-km="ប្រភេទ">Category</div>
                @foreach($products as $p)
                    <div class="cmp-val {{ $p->category ? '' : 'empty' }}">{{ $p->category?->name ?: '—' }}</div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
