@extends('layouts.storefront')

@section('title', 'Shop — SR MAC SHOP')

@section('content')
    {{-- TODO Phase 3: port the prototype's #cp-shop markup --}}
    <livewire:product-grid :categories="$categories" />
@endsection
