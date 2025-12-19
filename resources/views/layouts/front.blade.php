<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Fay Collection - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Google Font: Poppins (banyak dipakai di web modern) --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            /* Warna tema utama, bisa Bro ganti kalau mau */
            --primary-color: #6366f1;
            /* indigo/ungu kebiruan */
            --primary-soft: #eef2ff;
            /* ungu muda lembut */
            --accent-color: #f97316;
            /* oranye untuk highlight kecil */
            --bg-body: #f5f5f7;
            /* abu muda netral */
            --text-main: #111827;
            /* hampir hitam */
            --text-muted: #6b7280;
            --card-radius: 18px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-body);
            font-family: "Poppins", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text-main);
        }

        .navbar {
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-size: 0.95rem;
            color: var(--primary-color) !important;
        }

        .brand-badge {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 999px;
            background: var(--primary-soft);
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .nav-link {
            font-size: 0.9rem;
            font-weight: 500;
            color: #4b5563 !important;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
        }

        main {
            max-width: 1120px;
        }

        .hero-section {
            background: radial-gradient(circle at top left, #e0ecff 0, #fef9ff 45%, #e0e7ff 100%);
            border-radius: 26px;
            padding: 28px 24px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 18px 40px rgba(148, 163, 184, 0.28);
        }

        .hero-title {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1.25;
        }

        @media (min-width: 992px) {
            .hero-title {
                font-size: 2.1rem;
            }
        }

        .hero-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 999px;
            padding-inline: 20px;
            font-weight: 500;
            box-shadow: 0 12px 25px rgba(99, 102, 241, 0.35);
        }

        .btn-primary:hover {
            background-color: #4f46e5;
            border-color: #4f46e5;
            box-shadow: 0 16px 35px rgba(79, 70, 229, 0.45);
        }

        .btn-outline-dark {
            border-radius: 999px;
            font-size: 0.85rem;
        }

        .pill-soft {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 999px;
            background-color: #fef3c7;
            color: #92400e;
            font-size: 0.75rem;
        }

        .pill-soft-dot {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background-color: #f97316;
        }

        .product-card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            background-color: #ffffff;
            overflow: hidden;
            transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s;
            border: 1px solid transparent;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
            border-color: rgba(99, 102, 241, 0.4);
        }

        .product-image-placeholder {
            background: linear-gradient(135deg, #e5ebff, #fdf2ff);
            border-radius: 16px;
            height: 190px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .price-text {
            color: #16a34a;
            font-weight: 700;
        }

        .category-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 11px;
            border-radius: 999px;
            font-size: 0.75rem;
            background-color: var(--primary-soft);
            color: var(--primary-color);
        }

        .category-pill-dot {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background-color: var(--primary-color);
        }

        footer {
            font-size: 0.8rem;
            color: #9ca3af;
            background-color: #f9fafb;
        }

        .alert-floating {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 260px;
        }

        .floating-wa {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 1050;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: #22c55e;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.3);
        }

        .floating-wa:hover {
            background: #16a34a;
            color: #fff;
        }

        @media (max-width: 576px) {
            .floating-wa {
                left: 50%;
                transform: translateX(-50%);
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <div class="d-flex align-items-center gap-2">
                <span class="brand-badge">Handmade</span>
                <a class="navbar-brand" href="{{ route('home') }}">
                    Fay Collection
                </a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-dark btn-sm ms-lg-2" href="#product-list">
                            Lihat Produk
                        </a>
                    </li>
                    {{-- AUTH USER --}}
@auth
    @if(auth()->user()->role === 'admin')
        {{-- ADMIN --}}
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-outline-primary btn-sm ms-lg-2">
                <i class="bi bi-speedometer2 me-1"></i>
                Dashboard Admin
            </a>
        </li>

        <li class="nav-item ms-lg-1">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    Logout
                </button>
            </form>
        </li>
    @else
        {{-- CUSTOMER --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1"
               href="#"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false">
                <i class="bi bi-person-circle"></i>
                <span>{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-1"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    @endif
@else
    {{-- GUEST --}}
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-1" href="{{ route('login') }}">
            <i class="bi bi-person"></i>
            <span>Login</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="btn btn-outline-dark btn-sm ms-lg-2" href="{{ route('register') }}">
            Daftar
        </a>
    </li>
@endauth


                    <li class="nav-item">
                        <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                            <i class="bi bi-cart3" style="font-size: 1.2rem;"></i>
                            @php
                                $cart = session()->get('cart', []);
                                $cartCount = 0;
                                foreach ($cart as $item) {
                                    $cartCount += $item['quantity'];
                                }
                            @endphp
                            @if($cartCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.65rem;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 my-md-5">
        @if(session('success') || session('error'))
            <div class="alert alert-floating {{ session('success') ? 'alert-success' : 'alert-danger' }}">
                {{ session('success') ?? session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="py-3 mt-4 border-top">
        <div class="container d-flex justify-content-between flex-wrap gap-2">
            <span>© {{ date('Y') }} Fay Collection — crochet & knit accessories.</span>
            <span class="d-flex align-items-center gap-2">
                Dirajut dengan cinta di Indonesia.
                <a href="{{ route('admin.login') }}" class="text-decoration-none text-muted small">
                    Admin Login
                </a>

            </span>
        </div>
    </footer>

    <a href="https://wa.me/6285172343199?text=Halo%20Fay%20Collection,%20saya%20ingin%20bertanya%20tentang%20produk."
        class="floating-wa" target="_blank">
        <i class="bi bi-whatsapp"></i>
        Butuh bantuan?
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
