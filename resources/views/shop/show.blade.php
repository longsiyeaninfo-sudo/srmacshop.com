@extends('layouts.storefront')

@section('title', $product->name . ' — SR MAC SHOP')
@section('description', \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160))

@section('content')
    {{-- TODO Phase 3: port the prototype's #cp-detail markup with gallery, specs table, contact card --}}
    <article style="max-width:1200px;margin:0 auto;padding:32px 16px">
        <a href="{{ route('shop') }}">&larr; {{ __('Back to shop') }}</a>
        <h1>{{ $product->name }}</h1>
        <p style="color:#666">{{ $product->spec }}</p>
        <p style="font-size:24px;font-weight:600">${{ number_format($product->price_dollars, 0) }}</p>
        @if($product->description)
            <div>{!! nl2br(e($product->description)) !!}</div>
        @endif

    <livewire:loan-calculator :product-price="$product->price_dollars" />

        @if($related->count())
            <section style="margin-top:48px">
                <h2>{{ __('Related products') }}</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px">
                    @foreach($related as $rel)
                   <x-product-card :product="$rel" />
             @endforeach
          </div>
            </section>
        @endif
    </article>
@endsection
