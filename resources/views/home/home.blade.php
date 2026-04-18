<!-- resources/views/home/home.blade.php -->

@extends('layout')

@section('content')

@include('home.section.banner')

@endsection

@section('page-js')
<script src="{{ asset('js/home-banner.js') }}"></script>
@endsection