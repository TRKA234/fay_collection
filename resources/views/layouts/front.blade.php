<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Fay Collection - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Google Font: Poppins (banyak dipakai di web modern) --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            /* Warna tema utama, bisa Bro ganti kalau mau */
            --primary-color: #6366f1;   /* indigo/ungu kebiruan */
            --primary-soft: #eef2ff;    /* ungu muda lembut */
            --accent-color: #f97316;    /* oranye untuk highlight kecil */
            --bg-body: #f5f5f7;         /* abu muda netral */
            --text-main: #111827;       /* hampir hitam */
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

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Beranda</a>
                </li>
                {{-- Nanti bisa tambah menu lain --}}
                <li class="nav-item">
                    <a class="btn btn-outline-dark btn-sm ms-lg-2" href="#product-list">
                        Lihat Produk
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4 my-md-5">
    @yield('content')
</main>

<footer class="py-3 mt-4 border-top">
    <div class="container d-flex justify-content-between flex-wrap gap-2">
        <span>© {{ date('Y') }} Fay Collection — crochet & knit accessories.</span>
        <span>Dirajut dengan cinta di Indonesia.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
