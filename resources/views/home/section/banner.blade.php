<!-- resources/views/home/section/banner.blade.php -->

<!-- ===============================
DESKTOP / TABLET BANNER
=============================== -->
<div id="desktopBanner" class="carousel slide d-none d-md-block" data-bs-ride="carousel">

    <div class="carousel-indicators">
        <button type="button" data-bs-target="#desktopBanner" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#desktopBanner" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#desktopBanner" data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#desktopBanner" data-bs-slide-to="3"></button>
        <button type="button" data-bs-target="#desktopBanner" data-bs-slide-to="4"></button>
    </div>

    <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active">
            <img src="{{ asset('images/banner/desktop/banner1.webp') }}" class="w-100 banner-img-desktop" alt="Banner 1">

            <div class="banner-content">
                <span>New Arrival</span>
                <h1>Elegant Basket Bags</h1>
                <p>Crafted for style and everyday elegance.</p>
                <a href="/shop" class="btn-theme">Shop Now</a>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
            <img src="{{ asset('images/banner/desktop/banner1.webp') }}" class="w-100 banner-img-desktop" alt="Banner 2">

            <div class="banner-content">
                <span>Premium Collection</span>
                <h1>Luxury Handwoven Bags</h1>
                <p>Minimal design with timeless beauty.</p>
                <a href="/shop" class="btn-theme">Explore</a>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item">
            <img src="{{ asset('images/banner/desktop/banner1.webp') }}" class="w-100 banner-img-desktop" alt="Banner 3">

            <div class="banner-content">
                <span>Summer Style</span>
                <h1>Natural Fashion Trends</h1>
                <p>Perfect companion for sunny days.</p>
                <a href="/shop" class="btn-theme">Buy Now</a>
            </div>
        </div>

        <!-- Slide 4 -->
        <div class="carousel-item">
            <img src="{{ asset('images/banner/desktop/banner1.webp') }}" class="w-100 banner-img-desktop" alt="Banner 4">

            <div class="banner-content">
                <span>Exclusive</span>
                <h1>Designer Basket Picks</h1>
                <p>Curated elegance for modern women.</p>
                <a href="/shop" class="btn-theme">View More</a>
            </div>
        </div>

        <!-- Slide 5 -->
        <div class="carousel-item">
            <img src="{{ asset('images/banner/desktop/banner1.webp') }}" class="w-100 banner-img-desktop" alt="Banner 5">

            <div class="banner-content">
                <span>Limited Offer</span>
                <h1>Flat 20% Off</h1>
                <p>Shop premium handmade bags today.</p>
                <a href="/shop" class="btn-theme">Shop Deals</a>
            </div>
        </div>

    </div>

</div>



<!-- ===============================
MOBILE BANNER
=============================== -->
<div id="mobileBanner" class="carousel slide d-block d-md-none" data-bs-ride="carousel">

    <div class="carousel-inner">

        <div class="carousel-item active">
            <img src="{{ asset('images/banner/mobile/banner1.webp') }}" class="w-100 banner-img-mobile" alt="">
        </div>

        <div class="carousel-item">
            <img src="{{ asset('images/banner/mobile/banner1.webp') }}" class="w-100 banner-img-mobile" alt="">
        </div>

        <div class="carousel-item">
            <img src="{{ asset('images/banner/mobile/banner1.webp') }}" class="w-100 banner-img-mobile" alt="">
        </div>

        <div class="carousel-item">
            <img src="{{ asset('images/banner/mobile/banner1.webp') }}" class="w-100 banner-img-mobile" alt="">
        </div>

        <div class="carousel-item">
            <img src="{{ asset('images/banner/mobile/banner1.webp') }}" class="w-100 banner-img-mobile" alt="">
        </div>

    </div>

</div>