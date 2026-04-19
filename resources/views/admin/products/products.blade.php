<!-- resources/views/admin/products/products.blade.php -->

@extends('admin.layout')

@section('content')

<div class="admin-product-page">

    <div class="page-head mb-4">

        <h1 class="mb-1">Product Management</h1>

        <p class="text-muted mb-0">
            Manage categories, variations, products, stock and media.
        </p>

    </div>

    <!-- Tabs -->
    <ul class="nav nav-pills admin-tab-menu mb-4" id="productTab" role="tablist">

        <li class="nav-item">
            <button
                class="nav-link active"
                data-bs-toggle="pill"
                data-bs-target="#tabCategories"
                type="button"
            >
                Categories
            </button>
        </li>

        <li class="nav-item">
            <button
                class="nav-link"
                data-bs-toggle="pill"
                data-bs-target="#tabVariation"
                type="button"
            >
                Variations
            </button>
        </li>

        <li class="nav-item">
            <button
                class="nav-link"
                data-bs-toggle="pill"
                data-bs-target="#tabProduct"
                type="button"
            >
                Products
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">

        <div class="tab-pane fade show active" id="tabCategories">
            @include('admin.products.tabsection.categories')
        </div>

        <div class="tab-pane fade" id="tabVariation">
            @include('admin.products.tabsection.variation')
        </div>

        <div class="tab-pane fade" id="tabProduct">
            @include('admin.products.tabsection.product')
        </div>
    </div>

</div>

@endsection

@section('page-js')
<script src="{{ asset('js/admin/category.js') }}"></script>
<script src="{{ asset('js/admin/variationtype.js') }}"></script>
<script src="{{ asset('js/admin/variationvalue.js') }}"></script>

@endsection