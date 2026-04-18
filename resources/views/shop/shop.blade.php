<!-- resources/views/shop/shop.blade.php -->

@extends('layout')

@section('content')

@include('shop.section.banner')
@include('shop.section.product')

@endsection

@section('page-js')
<script src="{{ asset('js/shop-product.js') }}"></script>
@endsection