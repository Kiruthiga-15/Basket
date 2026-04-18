<!-- resources/views/admin/dashboard/dashboard.blade.php -->

@extends('admin.layout')

@section('content')

<div class="dashboard-page">

    <div class="page-title-wrap mb-4">

        <h1 class="mb-1">Dashboard</h1>

        <p class="text-muted mb-0">
            Welcome back, {{ session('admin_username') }}
        </p>

    </div>

    @include('admin.dashboard.section.overview-cards')

    @include('admin.dashboard.section.analytics')

    @include('admin.dashboard.section.orders-products')

    @include('admin.dashboard.section.extras')

</div>

@endsection

@section('page-js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="{{ asset('js/admin/admin-dashboard.js') }}"></script>

@endsection