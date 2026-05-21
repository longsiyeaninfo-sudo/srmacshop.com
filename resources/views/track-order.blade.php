@extends('layouts.storefront')

@section('title', 'Track Your Order — SR MAC SHOP')
@section('description', 'Track your SR MAC SHOP order status. Enter your order number and phone to check delivery progress.')

@section('content')
<section class="shop-section" style="background:var(--bg);padding-top:3rem">
    <livewire:order-tracker />
</section>
@endsection
