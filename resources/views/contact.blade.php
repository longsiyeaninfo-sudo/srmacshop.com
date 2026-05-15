@extends('layouts.storefront')

@section('title', 'Contact — SR MAC SHOP')

@section('content')
    {{-- TODO Phase 3: port #cp-contact markup --}}
    <section style="max-width:900px;margin:0 auto;padding:48px 16px">
        <h1>{{ __('Contact us') }}</h1>
      <p>{{ \App\Models\Setting::get('shop_phone', '+855 98 33 47 55') }}</p>
        <p>{{ \App\Models\Setting::get('shop_address', 'Borey Pibhu Thmey Kambol III, Sangkat Kambol, Phnom Penh') }}</p>
    </section>
@endsection
