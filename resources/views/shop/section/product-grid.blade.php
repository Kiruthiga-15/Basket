<!-- resources/views/shop/section/product-grid.blade.php -->

<div class="row g-4">

@for($i = 1; $i <= 8; $i++)

<div class="col-12 col-md-6 col-xl-4">

    <div class="product-card">

        <img
            src="{{ asset('product/product2.jpg') }}"
            class="img-fluid w-100"
            alt="Product"
        >

        <div class="product-info">

            <h5>Elegant Basket Bag</h5>

            <p>Premium Handcrafted Design</p>

            <div class="price-row">
                <span>₹1,499</span>
                <a href="/cart">Add</a>
            </div>

        </div>

    </div>

</div>

@endfor

</div>