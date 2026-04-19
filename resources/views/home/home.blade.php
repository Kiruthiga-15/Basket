<!-- resources/views/home/home.blade.php -->

@extends('layout')

@section('content')

@include('home.section.banner')

@endsection

@section('page-js')
<script src="{{ asset('js/frontend/home-banner.js') }}"></script>
@endsection