<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel – @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
        color: #334155;
    }

    /* ====== SIDEBAR PREMIUM ====== */
    .sidebar {
        width: 280px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        backdrop-filter: blur(20px);
        border-right: 2px solid rgba(148,163,184,0.15);
        box-shadow: 0 0 40px rgba(0,0,0,0.08);
        padding: 30px 20px;
        z-index: 999;
        overflow-y: auto;
        transition: 0.45s cubic-bezier(.25, .1, .25, 1.4);
    }

    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(148,163,184,0.1);
        border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(99,102,241,0.3);
        border-radius: 10px;
    }

    /* ===== SIDEBAR HEADER ===== */
    .sidebar-header {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 50px;
        line-height: 1.3;
        letter-spacing: 1px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar-header i {
        font-size: 1.8rem;
        filter: drop-shadow(0 0 8px rgba(99,102,241,0.2));
    }

    /* ===== NAV LINKS ===== */
    .nav-link-custom {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border-radius: 12px;
        font-size: 0.98rem;
        color: rgba(71,85,105,0.75);
        text-decoration: none;
        margin-bottom: 10px;
        transition: 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid transparent;
    }

    .nav-link-custom::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(99,102,241,0.08);
        transition: 0.3s ease;
        z-index: -1;
    }

    .nav-link-custom:hover::before {
        left: 0;
    }

    .nav-link-custom:hover {
        color: #4f46e5;
        transform: translateX(8px);
        box-shadow: 0 4px 15px rgba(99,102,241,0.15);
        border-color: rgba(99,102,241,0.2);
    }

    .nav-link-custom.active {
        background: linear-gradient(135deg, rgba(99,102,241,0.1) 0%, rgba(139,92,246,0.1) 100%);
        color: #4f46e5;
        box-shadow: 0 6px 20px rgba(99,102,241,0.15), inset 0 1px 0 rgba(99,102,241,0.2);
        border-color: rgba(99,102,241,0.3);
        font-weight: 600;
    }

    .nav-link-custom.active::after {
        content: "";
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 60%;
        background: linear-gradient(to bottom, #818cf8, #6366f1);
        border-radius: 4px 0 0 4px;
        box-shadow: 0 0 12px rgba(99,102,241,0.4);
    }

    .nav-link-custom i {
        font-size: 1.4rem;
        filter: drop-shadow(0 0 4px rgba(99,102,241,0.15));
    }

    .nav-section-title {
        font-size: 0.75rem;
        font-weight: 700;
        color: rgba(148,163,184,0.6);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 20px;
        margin-bottom: 12px;
        padding-left: 16px;
    }

    /* ====== TOGGLE BUTTON ====== */
    #sidebarToggle {
        display: none;
        position: fixed;
        top: 20px;
        left: 20px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border: 2px solid rgba(255,255,255,0.3);
        padding: 10px 14px;
        border-radius: 12px;
        color: white;
        font-size: 1.3rem;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(99,102,241,0.3);
        z-index: 1001;
        transition: 0.3s ease;
    }

    #sidebarToggle:hover {
        transform: scale(1.12) rotate(-2deg);
        box-shadow: 0 6px 30px rgba(99,102,241,0.4);
        border-color: rgba(255,255,255,0.5);
    }

    /* ====== CONTENT AREA ====== */
    .content-area {
        margin-left: 280px;
        padding: 30px;
        transition: 0.45s ease;
        min-height: 100vh;
    }

    /* ====== CARDS & STYLING ====== */
    .card {
        border: 1px solid rgba(99,102,241,0.1);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        background: #ffffff;
        backdrop-filter: blur(10px);
        transition: 0.3s ease;
        overflow: hidden;
        color: #334155;
    }

    .card:hover {
        box-shadow: 0 8px 30px rgba(99,102,241,0.12);
        transform: translateY(-2px);
        background: #ffffff;
    }

    .product-card {
        border: 1px solid rgba(99,102,241,0.08) !important;
    }

    /* ====== TABLE STYLING ====== */
    .table {
        background: transparent;
        color: #475569;
    }

    .table thead {
        background: linear-gradient(135deg, rgba(99,102,241,0.08) 0%, rgba(139,92,246,0.08) 100%);
        border-top: 2px solid rgba(99,102,241,0.15);
        border-bottom: 2px solid rgba(99,102,241,0.15);
    }

    .table th {
        color: #4f46e5;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 14px;
        border: none;
    }

    .table tbody tr {
        border-bottom: 1px solid rgba(99,102,241,0.08);
        transition: 0.2s ease;
    }

    .table tbody tr:hover {
        background: rgba(99,102,241,0.05);
    }

    .table td {
        padding: 14px;
        vertical-align: middle;
        color: #475569;
    }

    /* ====== BUTTONS ====== */
    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border: none;
        box-shadow: 0 4px 15px rgba(99,102,241,0.3);
        transition: 0.3s ease;
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(99,102,241,0.4);
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
    }

    .btn-outline-primary {
        color: #6366f1;
        border: 2px solid #6366f1;
        transition: 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: #8b5cf6;
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-danger {
        color: #ef4444;
        border: 2px solid #ef4444;
    }

    .btn-outline-danger:hover {
        background: #dc2626;
        border-color: #dc2626;
        color: white;
    }

    .btn-light {
        background: rgba(226,232,240,0.5);
        color: #334155;
        border: 1px solid rgba(99,102,241,0.15);
    }

    .btn-light:hover {
        background: rgba(226,232,240,0.8);
        color: #1e293b;
    }

    .btn-outline-light {
        color: #334155;
        border: 1px solid rgba(99,102,241,0.2);
    }

    .btn-outline-light:hover {
        background: rgba(99,102,241,0.08);
        color: #1e293b;
        border-color: rgba(99,102,241,0.3);
    }

    /* ====== ALERTS ====== */
    .alert {
        border: 2px solid;
        border-radius: 14px;
        backdrop-filter: blur(10px);
        color: #1e293b;
    }

    .alert-success {
        background: rgba(34,197,94,0.1);
        border-color: rgba(34,197,94,0.3);
        color: #059669;
    }

    .alert-warning {
        background: rgba(251,146,60,0.1);
        border-color: rgba(251,146,60,0.3);
        color: #b45309;
    }

    .alert-link {
        color: inherit;
        text-decoration: underline;
    }

    /* ====== BADGES ====== */
    .badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .bg-success {
        background: rgba(34,197,94,0.2) !important;
        color: #059669;
    }

    .bg-danger {
        background: rgba(239,68,68,0.2) !important;
        color: #dc2626;
    }

    .bg-warning {
        background: rgba(251,146,60,0.2) !important;
        color: #b45309;
    }

    .bg-primary {
        background: linear-gradient(135deg, rgba(99,102,241,0.15) 0%, rgba(139,92,246,0.15) 100%) !important;
        color: #4f46e5;
    }

    /* ====== FORM CONTROL ====== */
    .form-control, .form-select {
        border: 2px solid rgba(99,102,241,0.15);
        border-radius: 12px;
        background: #ffffff;
        padding: 10px 14px;
        font-size: 0.95rem;
        transition: 0.3s ease;
        color: #334155;
    }

    .form-control::placeholder {
        color: rgba(148,163,184,0.6);
    }

    .form-control:focus, .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        background: #ffffff;
        color: #1e293b;
    }

    .form-label {
        color: #475569;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    /* ====== TEXT STYLING ====== */
    .text-dark {
        color: #1e293b !important;
    }

    .text-muted {
        color: rgba(148,163,184,0.8) !important;
    }

    .text-primary {
        color: #4f46e5 !important;
    }

    .text-success {
        color: #059669 !important;
    }

    .text-warning {
        color: #b45309 !important;
    }

    h1, h2, h3, h4, h5, h6 {
        color: #1e293b;
    }

    .h4, .h5, .h6 {
        color: #334155;
    }

    .fw-700 {
        font-weight: 700;
    }

    .fw-600 {
        font-weight: 600;
    }

    /* ====== LIST GROUP ====== */
    .list-group-item {
        background: transparent;
        border: 1px solid rgba(99,102,241,0.1);
        color: #475569;
    }

    .list-group-item:first-child {
        border-top: 0;
    }

    /* ====== RESPONSIVE ====== */
    @media (max-width: 1024px) {
        .sidebar {
            width: 250px;
        }

        .content-area {
            margin-left: 250px;
            padding: 25px;
        }
    }

    @media (max-width: 768px) {
        /* Tampilkan toggle button di mobile */
        #sidebarToggle {
            display: block;
        }

        .sidebar {
            width: 250px;
            transform: translateX(-100%);
            z-index: 1000;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .content-area {
            margin-left: 0;
            padding: 20px;
            padding-top: 80px;
        }

        .content-area.with-sidebar {
            margin-left: 0;
        }
    }
    </style>

</head>
<body>

<button id="sidebarToggle"><i class="bi bi-list"></i></button>

{{-- Sidebar --}}
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <i class="bi bi-bag-heart"></i>
        <div>
            Fay<br>
            Collection
        </div>
    </div>

    <div class="nav-section-title">Menu Utama</div>

    <a href="{{ route('admin.dashboard') }}"
       class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('admin.products.index') }}"
       class="nav-link-custom {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i>
        <span>Kelola Produk</span>
    </a>

    <div class="nav-section-title" style="margin-top: 30px;">Lainnya</div>

    <a href="#" class="nav-link-custom" style="opacity:0.6; cursor: not-allowed;">
        <i class="bi bi-tag"></i>
        <span>Kategori</span>
        <span class="badge bg-warning text-dark ms-auto" style="font-size: 0.65rem;">Soon</span>
    </a>

    <a href="{{ route('home') }}" target="_blank" class="nav-link-custom">
        <i class="bi bi-globe2"></i>
        <span>Lihat Website</span>
    </a>

    <div class="nav-section-title" style="margin-top: 30px;">Akun</div>

    <form action="{{ route('logout') }}" method="POST" class="mt-2">
        @csrf
        <button style="background:none;border:none;width:100%;text-align:left;" class="nav-link-custom">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </button>
    </form>
</div>

{{-- Content --}}
<div id="contentArea" class="content-area">
    @yield('content')
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const contentArea = document.getElementById('contentArea');
    const toggleBtn = document.getElementById('sidebarToggle');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('show');
    });

    // Auto close sidebar on mobile ketika klik di luar sidebar
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 768) {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
</script>

</body>
</html>
