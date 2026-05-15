@extends('layouts.storefront')

@section('title', 'SR MAC SHOP — Think Different. Buy Smarter.')

@section('content')
    {{-- TODO Phase 3: port the prototype's #cp-home markup verbatim --}}
    <section style="max-width:1200px;margin:0 auto;padding:64px 16px">
        <h1 style="font-size:48px;margin:0 0 16px">{{ __('Think Different. Buy Smarter.') }}</h1>
        <p style="font-size:18px;color:#555">
          {{ __('Premium MacBooks in Phnom Penh.') }}
        </p>
        <p style="margin-top:24px">
            <a href="{{ route('shop') }}" style="display:inline-block;padding:12px 24px;background:#007AFF;color:#fff;border-radius:14px;text-decoration:none">
       {{ __('Shop now') }}
            </a>
        </p>
    </section>

    @if($featured->count())
        <section style="max-width:1200px;margin:0 auto;padding:32px 16px">
            <h2>{{ __('Top MacBooks in Cambodia 2025') }}</h2>
         <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px">
              @foreach($featured as $product)
                    <x-product-card :product="$product" />
          @endforeach
            </div>
        </section>
    @endif
@endsection
