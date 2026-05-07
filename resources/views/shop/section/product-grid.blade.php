<!-- resources/views/shop/section/product-grid.blade.php -->

<div class="row g-4" id="productGridContainer">

@if(isset($products) && $products->count() > 0)
@foreach($products as $product)

<div class="col-12 col-md-6 col-xl-4">

        <div class="product-card">

            @if($product->images && $product->images->count() > 0)
            <div class="product-image-container">
                <img
                    src="{{ asset('storage/' . $product->images->first()->image) }}"
                    class="img-fluid w-100"
                    alt="{{ $product->name }}"
                >
                <button class="wishlist-btn {{ Auth::check() && in_array($product->id, $wishlistedProductIds ?? []) ? 'active' : '' }}"
                        data-product-id="{{ $product->id }}">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
            @else
            <div class="product-image-container">
                <img
                    src="{{ asset('product/product2.jpg') }}"
                    class="img-fluid w-100"
                    alt="{{ $product->name }}"
                >
                <button class="wishlist-btn {{ Auth::check() && in_array($product->id, $wishlistedProductIds ?? []) ? 'active' : '' }}"
                        data-product-id="{{ $product->id }}">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
            @endif        <div class="product-info">

            <h5>{{ $product->name }}</h5>

            <p>{{ Str::limit($product->short_description ?? 'Premium Handcrafted Design', 50) }}</p>

            <div class="price-row">
                @if($product->discount_price && $product->discount_price < $product->price)
                <span>
                    <del>₹{{ number_format($product->price, 2) }}</del>
                    ₹{{ number_format($product->discount_price, 2) }}
                </span>
                @else
                <span>₹{{ number_format($product->price, 2) }}</span>
                @endif
                <a href="/cart" class="add-to-cart-btn" data-product-id="{{ $product->id }}">Add</a>
            </div>

            @if($product->variationTypeSize && $product->variationValueSize)
            <small class="text-muted">{{ $product->variationTypeSize->name }}: {{ $product->variationValueSize->value_name }}</small>
            @endif

            @if($product->variationTypeColor && $product->variationValueColor)
            <small class="text-muted">{{ $product->variationTypeColor->name }}: {{ $product->variationValueColor->value_name }}</small>
            @endif

        </div>

    </div>

</div>

@endforeach
@else

<div class="col-12">
    <div class="text-center py-5">
        <h4>No products found</h4>
        <p>Please check back later for new products.</p>
    </div>
</div>

@endif

</div>

@if(isset($products))
<div class="row mt-4">
    <div class="col-12">
        <nav aria-label="Product pagination">
            {{ $products->links() }}
        </nav>
    </div>
</div>
@endif