@extends('layouts.storefront')

@section('title', 'Shop — SR MAC SHOP')

@section('content')
<div id="cp-shop">
    <livewire:product-grid :categories="$categories" />
</div>
@endsection
