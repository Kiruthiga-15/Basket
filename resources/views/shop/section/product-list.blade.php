<!-- resources/views/shop/section/product-list.blade.php -->

<div class="list-product-wrap">

@for($i = 1; $i <= 6; $i++)

<div class="list-product-card">

    <div class="row align-items-center g-3">

        <div class="col-12 col-md-4">
            <img
                src="{{ asset('product/product3.jpg') }}"
                class="img-fluid w-100"
                alt="Product"
            >
        </div>

        <div class="col-12 col-md-8">

            <div class="list-info">

                <h4>Luxury Basket Tote Bag</h4>

                <p>
                    Stylish handcrafted bag for daily use,
                    travel and premium fashion styling.
                </p>

                <div class="price-row">
                    <span>₹1,899</span>
                    <a href="/cart">Add to Cart</a>
                </div>

            </div>

        </div>

    </div>

</div>

@endfor

</div>