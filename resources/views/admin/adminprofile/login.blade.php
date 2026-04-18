<!-- resources/views/admin/adminprofile/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login | BasketBags</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/admintheme.css') }}">
</head>

<body class="admin-login-page">

<section class="admin-login-section">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

                <div class="admin-login-card">

                    <!-- Logo -->
                    <div class="login-logo-wrap">

                        <h1>BasketBags</h1>

                        <p>
                            Admin Dashboard Access
                        </p>

                    </div>

                    <!-- Error -->
                    @if(session('error'))

                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>

                    @endif

                    <!-- Form -->
                    <form method="POST" action="/admin/login">

                        @csrf

                        <!-- Username -->
                        <div class="mb-3">

                            <label class="form-label">
                                Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                class="form-control login-input"
                                placeholder="Enter username"
                                required
                            >

                        </div>

                        <!-- Password -->
                        <div class="mb-4">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control login-input"
                                placeholder="Enter password"
                                required
                            >

                        </div>

                        <!-- Button -->
                        <button type="submit" class="btn login-btn w-100">

                            Login

                        </button>

                    </form>

                    <!-- Footer -->
                    <div class="login-footer-text">

                        Secure Admin Access Only

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

</body>
</html>