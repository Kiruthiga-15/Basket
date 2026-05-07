<!-- resources/views/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Basket Bags</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="{{ asset('css/baskettheme.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">
@if(Auth::check())
<meta name="user-id" content="{{ Auth::id() }}">
@endif

<style>
    .product-image-container {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .wishlist-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: white;
        border: 2px solid #ddd;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        padding: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #999;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .wishlist-btn:hover {
        border-color: #ff0000;
        color: #ff0000;
        background: #fff5f5;
    }

    .wishlist-btn.active {
        border-color: #ff0000;
        color: #ff0000;
        background: #fff5f5;
    }

    .wishlist-btn i {
        pointer-events: none;
    }

    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }

    .wishlist-toast {
        animation: slideIn 0.3s ease;
    }

    .wishlist-toast.slideOut {
        animation: slideOut 0.3s ease;
    }
</style>
</head>

<body>

@include('commonsection.navbar')
<!-- PAGE CONTENT -->
<main>
    @yield('content')
</main>

@include('commonsection.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/lucide@latest"></script>

<script>
lucide.createIcons();

/* Sticky Navbar */
window.addEventListener('scroll', function () {

    let topBar  = document.getElementById('topNavbar');
    let mainNav = document.getElementById('mainNavbar');

    if (window.scrollY > 60) {

        if (topBar) {
            topBar.classList.add('hide-topbar');
        }

        mainNav.classList.add('sticky-navbar');

    } else {

        if (topBar) {
            topBar.classList.remove('hide-topbar');
        }

        mainNav.classList.remove('sticky-navbar');
    }

});

/* Sidebar */
const openBtn   = document.getElementById('openSidebar');
const closeBtn  = document.getElementById('closeSidebar');
const sidebar   = document.getElementById('mobileSidebar');
const overlay   = document.getElementById('sidebarOverlay');

openBtn.addEventListener('click', function () {
    sidebar.classList.add('show-sidebar');
    overlay.classList.add('show-overlay');
});

closeBtn.addEventListener('click', function () {
    sidebar.classList.remove('show-sidebar');
    overlay.classList.remove('show-overlay');
});

overlay.addEventListener('click', function () {
    sidebar.classList.remove('show-sidebar');
    overlay.classList.remove('show-overlay');
});
</script>
@yield('page-js')

</body>
</html>