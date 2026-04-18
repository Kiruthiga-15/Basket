<!-- resources/views/shop/section/product.blade.php -->

<section class="shop-product-section" id="shop-products">

    <div class="container">

        <div class="row g-4">

            <!-- LEFT FILTER -->
            <div class="col-12 col-lg-3">
                @include('shop.section.product-filter')
            </div>

            <!-- RIGHT PRODUCTS -->
            <div class="col-12 col-lg-9">

                <!-- Top Bar -->
                <div class="product-topbar">

                    <p>Showing 12 Products</p>

                    <div class="view-switcher">

                        <button class="view-btn active" id="gridViewBtn">
                            Grid
                        </button>

                        <button class="view-btn" id="listViewBtn">
                            List
                        </button>

                    </div>

                </div>

                <!-- Grid View -->
                <div id="gridViewWrap">
                    @include('shop.section.product-grid')
                </div>

                <!-- List View -->
                <div id="listViewWrap" style="display:none;">
                    @include('shop.section.product-list')
                </div>

            </div>

        </div>

    </div>

</section>