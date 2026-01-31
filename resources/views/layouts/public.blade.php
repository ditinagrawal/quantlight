<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'ByteWork Blog'))</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: #333;
            overflow-x: hidden;
            background-color: #fff;
        }

        /* Navbar */
        .main-navbar {
            background: #1a1a1a;
            padding: 15px 0;
        }

        .main-navbar .navbar-brand {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .main-navbar .navbar-brand span {
            color: #c9a96e;
        }

        .main-navbar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .main-navbar .nav-link:hover {
            color: #c9a96e;
        }

        .main-navbar .btn-login {
            background: #c9a96e;
            color: #fff;
            padding: 8px 25px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .main-navbar .btn-login:hover {
            background: #a88a5a;
            color: #fff;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1200') center/cover no-repeat;
            min-height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .hero-content h1 {
            color: #fff;
            font-size: 4rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .breadcrumb-nav {
            background: transparent;
            justify-content: center;
            margin-bottom: 0;
        }

        .breadcrumb-nav .breadcrumb-item,
        .breadcrumb-nav .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            text-decoration: none;
        }

        .breadcrumb-nav .breadcrumb-item a:hover {
            color: #c9a96e;
        }

        .breadcrumb-nav .breadcrumb-item.active {
            color: #fff;
        }

        .breadcrumb-nav .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.5);
            content: "/";
        }

        /* Footer */
        .main-footer {
            background: #1a1a1a;
            color: #fff;
            padding: 40px 0 20px;
            margin-top: 80px;
        }

        .main-footer .footer-brand {
            font-size: 1.5rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
        }

        .main-footer .footer-brand span {
            color: #c9a96e;
        }

        .main-footer p {
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 0;
        }

        .main-footer .social-links a {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.2rem;
            margin-left: 15px;
            transition: color 0.3s ease;
        }

        .main-footer .social-links a:hover {
            color: #c9a96e;
        }

        /* Divider */
        .divider {
            width: 60px;
            height: 2px;
            background: #c9a96e;
            display: inline-block;
            margin: 0 15px;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
        }

        @yield('styles')
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="main-navbar navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <span>Byte</span>Work
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Blog</a>
                    </li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item ms-2">
                                <a class="btn btn-login" href="{{ route('login') }}">Login</a>
                            </li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <a href="/" class="footer-brand">
                        <span>Byte</span>Work
                    </a>
                </div>
                <div class="col-md-4 text-center">
                    <p>&copy; {{ date('Y') }} ByteWork Blog. All rights reserved.</p>
                </div>
                <div class="col-md-4 text-end social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>