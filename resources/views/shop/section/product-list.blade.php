<!-- resources/views/shop/section/product-list.blade.php -->

<div class="list-product-wrap" id="productListContainer">

@if(isset($products) && $products->count() > 0)
@foreach($products as $product)

<div class="list-product-card">

    <div class="row align-items-center g-3">

        <div class="col-12 col-md-4">
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
                    src="{{ asset('product/product3.jpg') }}"
                    class="img-fluid w-100"
                    alt="{{ $product->name }}"
                >
                <button class="wishlist-btn {{ Auth::check() && in_array($product->id, $wishlistedProductIds ?? []) ? 'active' : '' }}"
                        data-product-id="{{ $product->id }}">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
            @endif
        </div>

        <div class="col-12 col-md-8">

            <div class="list-info">

                <h4>{{ $product->name }}</h4>

                <p>
                    {{ $product->short_description ?? 'Stylish handcrafted bag for daily use, travel and premium fashion styling.' }}
                </p>

                @if($product->category)
                <small class="text-muted">Category: {{ $product->category->name }}</small><br>
                @endif

                @if($product->variationTypeSize && $product->variationValueSize)
                <small class="text-muted">{{ $product->variationTypeSize->name }}: {{ $product->variationValueSize->value_name }}</small><br>
                @endif

                @if($product->variationTypeColor && $product->variationValueColor)
                <small class="text-muted">{{ $product->variationTypeColor->name }}: {{ $product->variationValueColor->value_name }}</small><br>
                @endif

                @if($product->sku)
                <small class="text-muted">SKU: {{ $product->sku }}</small><br>
                @endif

                @if($product->stock)
                <small class="text-muted">Stock: {{ $product->stock }}</small><br>
                @endif

                <div class="price-row">
                    @if($product->discount_price && $product->discount_price < $product->price)
                    <span>
                        <del>₹{{ number_format($product->price, 2) }}</del>
                        ₹{{ number_format($product->discount_price, 2) }}
                    </span>
                    @else
                    <span>₹{{ number_format($product->price, 2) }}</span>
                    @endif
                    <a href="/cart" class="add-to-cart-btn" data-product-id="{{ $product->id }}">Add to Cart</a>
                </div>

            </div>

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