<!-- resources/views/admin/layout.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>BasketBags Admin Panel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/admintheme.css') }}">
</head>

<body>

<div class="admin-wrapper">

    <!-- =======================
    SIDEBAR
    ======================== -->
    <aside class="admin-sidebar" id="adminSidebar">

        <div class="sidebar-logo">
            <a href="/admin/dashboard">BasketBags</a>
        </div>

        <ul class="sidebar-menu">

            <li>
                <a href="/admin/dashboard">
                    <i data-lucide="layout-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="/admin/products">
                    <i data-lucide="shopping-bag"></i>
                    <span>Products</span>
                </a>
            </li>

            <li>
                <a href="/admin/orders">
                    <i data-lucide="clipboard-list"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li>
                <a href="/admin/customers">
                    <i data-lucide="users"></i>
                    <span>Customers</span>
                </a>
            </li>

            <li>
                <a href="/admin/settings">
                    <i data-lucide="settings"></i>
                    <span>Settings</span>
                </a>
            </li>

            <li>
                <a href="/admin/adminprofile">
                    <i data-lucide="user-circle"></i>
                    <span>Profile</span>
                </a>
            </li>

        </ul>

    </aside>

    <!-- =======================
    MAIN AREA
    ======================== -->
    <div class="admin-main">

        <!-- Header -->
        <header class="admin-header">

            <div class="header-left">

                <button class="mobile-toggle-btn" id="openAdminSidebar">
                    <i data-lucide="menu"></i>
                </button>

                <h4>Admin Panel</h4>

            </div>

            <!-- REPLACE only header-right section inside admin/layout.blade.php -->

            <div class="header-right">

                <!-- Notification -->
                <a href="#" class="header-icon">
                    <i data-lucide="bell"></i>
                </a>

                <!-- Profile Dropdown -->
                <div class="admin-profile-dropdown">

                    <button
                        type="button"
                        class="header-icon profile-toggle-btn"
                        id="profileToggleBtn"
                    >
                        <i data-lucide="user"></i>
                    </button>

                    <div class="profile-dropdown-menu" id="profileDropdownMenu">

                        <div class="profile-name">

                            {{ session('admin_username') }}

                        </div>

                        <a href="/admin/adminprofile">
                            My Profile
                        </a>

                        <a href="/admin/logout">
                            Logout
                        </a>

                    </div>

                </div>

            </div>

        </header>

        <!-- Content -->
        <main class="admin-content">
            @yield('content')
        </main>

    </div>

    <!-- Global Toast -->
    <div id="globalToast" class="global-toast">
        <span id="globalToastMsg"></span>
    </div>
</div>

<!-- Overlay -->
<div class="admin-overlay" id="adminOverlay"></div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/lucide@latest"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    lucide.createIcons();

    /* Sidebar */
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('adminOverlay');
    const openBtn = document.getElementById('openAdminSidebar');

    if (openBtn) {
        openBtn.addEventListener('click', function () {
            sidebar.classList.add('show-admin-sidebar');
            overlay.classList.add('show-admin-overlay');
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show-admin-sidebar');
            overlay.classList.remove('show-admin-overlay');
        });
    }

    /* Profile Dropdown */
    const profileBtn  = document.getElementById('profileToggleBtn');
    const profileMenu = document.getElementById('profileDropdownMenu');

    if (profileBtn) {

        profileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            profileMenu.classList.toggle('show-dropdown');
        });

        document.addEventListener('click', function () {
            profileMenu.classList.remove('show-dropdown');
        });

        profileMenu.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }
});
</script>
<script>
function showToast(message, type = 'success')
{
    let toast = document.getElementById('globalToast');
    let msg   = document.getElementById('globalToastMsg');

    if (!toast || !msg) return;

    msg.innerText = message;

    toast.classList.remove(
        'toast-success',
        'toast-error',
        'toast-warning'
    );

    if (type === 'success') {
        toast.classList.add('toast-success');
    }

    if (type === 'error') {
        toast.classList.add('toast-error');
    }

    if (type === 'warning') {
        toast.classList.add('toast-warning');
    }

    toast.classList.add('show-global-toast');

    setTimeout(function () {
        toast.classList.remove('show-global-toast');
    }, 3000);
}
</script>

@yield('page-js')

</body>
</html>