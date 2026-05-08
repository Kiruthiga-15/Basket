<!-- resources/views/shop/section/product-filter.blade.php -->

<div class="product-filter-box">

    <h4>Filters</h4>

    <!-- Search -->
    <div class="filter-group">
        <h6>Search</h6>
        <input type="text" id="searchFilter" class="form-control" placeholder="Search products...">
    </div>

    <!-- Category -->
    <div class="filter-group">
        <h6>Category</h6>
        <select id="categoryFilter" class="form-select">
            <option value="">All Categories</option>
            @if(isset($categories))
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
            @endif
        </select>
    </div>

    <!-- Price Range -->
    <div class="filter-group">
        <h6>Price Range</h6>
        <div class="price-inputs">
            <input type="number" id="priceMinFilter" class="form-control mb-2" placeholder="Min price">
            <input type="number" id="priceMaxFilter" class="form-control" placeholder="Max price">
        </div>
    </div>

    <!-- Apply Filters Button -->
    <div class="filter-group filter-actions">
        <button id="applyFiltersBtn" class="btn btn-theme w-100">Apply Filters</button>
        <button id="clearFiltersBtn" class="btn btn-theme-outline w-100 mt-2">Clear Filters</button>
    </div>

</div>