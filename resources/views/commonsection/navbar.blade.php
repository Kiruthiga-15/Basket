
<!-- =========================
TOP INFO BAR (Desktop)
========================= -->
<div class="basket-top-navbar d-none d-md-block" id="topNavbar">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-6">
                <div class="basket-topbar-left">
                    <span><i data-lucide="mail"></i> hello@basketbags.com</span>
                    <span><i data-lucide="phone"></i> +91 98765 43210</span>
                </div>
            </div>

            <div class="col-md-6 text-end">
                <div class="basket-topbar-right">
                    <a href="#"><i data-lucide="instagram"></i></a>
                    <a href="#"><i data-lucide="facebook"></i></a>
                    <a href="#"><i data-lucide="pin"></i></a>
                    <a href="#"><i data-lucide="message-circle"></i></a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- =========================
MAIN NAVBAR
========================= -->
<header class="basket-main-navbar" id="mainNavbar">

<div class="container">
<div class="row align-items-center gy-3">

    <!-- MOBILE MENU ICON -->
    <div class="col-2 d-md-none">
        <button class="basket-mobile-menu-btn" id="openSidebar">
            <i data-lucide="menu"></i>
        </button>
    </div>

    <!-- LOGO -->
    <div class="col-8 col-md-3 text-center text-md-start">
        <div class="basket-nav-logo">
            <a href="/">BasketBags</a>
        </div>
    </div>

    <!-- RIGHT ICONS -->
    <div class="col-2 col-md-2 text-end order-md-4">
        <div class="basket-nav-icons justify-content-end">
            <a href="/cart"><i data-lucide="shopping-cart"></i></a>
            @if(Auth::check())
                <div class="user-dropdown">
                    <button class="user-btn">
                        <i data-lucide="user"></i>
                    </button>
                    <div class="user-dropdown-menu">
                        <a href="/wishlist">Wishlist</a>
                        <a href="/profile">Profile</a>
                        <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;">Logout</a>
                        <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <a href="/login" class="login-link"><i data-lucide="user"></i></a>
            @endif
        </div>
    </div>

    <!-- SEARCH -->
    <div class="col-12 col-md-4 order-3 order-md-2">
        <div class="basket-nav-search">
            <form>
                <input type="text" placeholder="Search bags...">
                <button type="submit">
                    <i data-lucide="search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- DESKTOP MENU -->
    <div class="col-md-3 d-none d-md-block order-md-3">
        <nav class="basket-nav-menu justify-content-center">
            <a href="/">Home</a>
            <a href="/shop">Shop</a>
        </nav>
    </div>

</div>
</div>

</header>

<!-- =========================
MOBILE SIDEBAR
========================= -->
<div class="basket-mobile-sidebar" id="mobileSidebar">

    <div class="basket-sidebar-header">
        <h5>Menu</h5>

        <button class="basket-close-sidebar" id="closeSidebar">
            <i data-lucide="x"></i>
        </button>
    </div>

    <div class="basket-sidebar-links">
        <a href="/">Home</a>
        <a href="/shop">Shop</a>
        @if(Auth::check())
            <a href="/wishlist">Wishlist</a>
            <a href="/profile">Profile</a>
            <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;">Logout</a>
            <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
        @else
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        @endif
    </div>

</div>

<!-- Overlay -->
<div class="basket-sidebar-overlay" id="sidebarOverlay"></div>
