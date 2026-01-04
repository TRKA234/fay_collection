<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Fay Collection - @yield('title', 'Beranda')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fay Collection - Produk rajut handmade berkualitas tinggi. Tas rajut, sepatu rajut, dan aksesoris rajut lainnya.">

    {{-- Google Font: Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6366f1;
            --primary-soft: #eef2ff;
            --accent-color: #f97316;
            --bg-body: #f5f5f7;
            --text-main: #111827;
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            transition: color 0.2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
        }

        main {
            flex: 1;
            max-width: 1120px;
            width: 100%;
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
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #4f46e5;
            border-color: #4f46e5;
            box-shadow: 0 16px 35px rgba(79, 70, 229, 0.45);
            transform: translateY(-2px);
        }

        .btn-outline-dark {
            border-radius: 999px;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .btn-outline-dark:hover {
            transform: translateY(-1px);
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
            margin-top: auto;
        }

        .alert-floating {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 260px;
            animation: slideInRight 0.3s ease;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .floating-wa {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 1050;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 999px;
            background: #22c55e;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.3);
            transition: all 0.3s ease;
        }

        .floating-wa:hover {
            background: #16a34a;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(34, 197, 94, 0.4);
        }

        @media (max-width: 576px) {
            .floating-wa {
                left: 50%;
                transform: translateX(-50%);
                font-size: 0.85rem;
                padding: 10px 16px;
            }
        }

        .card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .badge {
            font-weight: 500;
        }
    </style>

    @stack('styles')
</head>

