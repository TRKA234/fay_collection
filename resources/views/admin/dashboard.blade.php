@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success py-2 mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-warning py-2 mb-3">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        </div>
    @endif

    {{-- Banner atas / welcome --}}
    <div class="mb-4">
        <div class="p-4 p-md-4 card">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <span class="badge bg-primary mb-2 d-inline-flex align-items-center gap-1">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard Admin
                    </span>
                    <h1 class="h4 mt-2 mb-1">
                        Halo, {{ $user->name }} 👋
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
                        Pantau toko, kelola produk, dan lihat notifikasi penting di satu tempat.
                    </p>
                </div>
                <div class="text-end">
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-primary btn-sm mb-2">
                        <i class="bi bi-globe2 me-1"></i>Lihat Website
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Baris statistik singkat --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div style="
                                width: 50px;height:50px;border-radius:14px;
                                display:flex;align-items:center;justify-content:center;
                                background:#eef2ff;color:#4f46e5;font-size:1.5rem;
                            ">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Total Produk</div>
                        <div class="h5 mb-0 fw-bold">{{ $totalProducts }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div style="
                                width: 50px;height:50px;border-radius:14px;
                                display:flex;align-items:center;justify-content:center;
                                background:#dcfce7;color:#16a34a;font-size:1.5rem;
                            ">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Produk Aktif</div>
                        <div class="h5 mb-0 fw-bold">{{ $activeProducts }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div style="
                                width: 50px;height:50px;border-radius:14px;
                                display:flex;align-items:center;justify-content:center;
                                background:#fef3c7;color:#f97316;font-size:1.5rem;
                            ">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Stok Menipis</div>
                        <div class="h5 mb-0 fw-bold">{{ $lowStockCount }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div style="
                                width: 50px;height:50px;border-radius:14px;
                                display:flex;align-items:center;justify-content:center;
                                background:#ffedd5;color:#f97316;font-size:1.5rem;
                            ">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <div>
                        <div class="text-muted" style="font-size:0.8rem;">Pesanan Pending</div>
                        <div class="h5 mb-0 fw-bold">{{ $pendingOrdersCount }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Notifikasi utama --}}
    <div class="mb-4">
        @if($lowStockCount > 0)
            <div class="alert alert-warning py-3 mb-0">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Peringatan:</strong> Ada {{ $lowStockCount }} produk dengan stok &le; 3. 
                <a href="{{ route('admin.products.index') }}" class="alert-link">Cek produk sekarang</a>
            </div>
        @else
            <div class="alert alert-success py-3 mb-0">
                <i class="bi bi-check-circle me-2"></i>
                Semua stok aman. Tidak ada produk dengan stok menipis.
            </div>
        @endif
    </div>

    {{-- Menu pilihan admin --}}
    <div class="row g-3 mb-4">
        {{-- Kelola Produk --}}
        <div class="col-md-4">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-reset">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h2 class="h6 mb-0">Kelola Produk</h2>
                                <span style="
                                            width: 32px;height:32px;border-radius:12px;
                                            display:flex;align-items:center;justify-content:center;
                                            background:#eef2ff;color:#4f46e5;
                                        ">
                                    <i class="bi bi-box-seam"></i>
                                </span>
                            </div>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;">
                                Tambah, ubah, dan hapus produk tas, sepatu, gantungan kunci, dan lainnya.
                            </p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2" style="font-size:0.85rem;">
                            <span>Total: <strong>{{ $totalProducts }}</strong> produk</span>
                            <span class="badge bg-primary">Masuk</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Catat Pesanan --}}
        <div class="col-md-4">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-reset">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h2 class="h6 mb-0">Catatan Pesanan</h2>
                                <span style="
                                            width: 32px;height:32px;border-radius:12px;
                                            display:flex;align-items:center;justify-content:center;
                                            background:#dcfce7;color:#16a34a;
                                        ">
                                    <i class="bi bi-cart-check"></i>
                                </span>
                            </div>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;">
                                Catat pesanan manual yang masuk dari WhatsApp atau media lainnya.
                            </p>
                        </div>
                        <span class="badge bg-primary align-self-start mt-2">Masuk</span>
                    </div>
                </div>
            </a>
        </div>

        {{-- Kelola Kategori --}}
        <div class="col-md-4">
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-reset">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h2 class="h6 mb-0">Kelola Kategori</h2>
                                <span style="
                                            width: 32px;height:32px;border-radius:12px;
                                            display:flex;align-items:center;justify-content:center;
                                            background:#fee2e2;color:#b91c1c;
                                        ">
                                    <i class="bi bi-tag"></i>
                                </span>
                            </div>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;">
                                Atur kategori produk seperti Tas Rajut, Sepatu Rajut, dan lainnya.
                            </p>
                        </div>
                        <span class="badge bg-primary align-self-start mt-2">Masuk</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Dua panel bawah: stok menipis & produk terbaru --}}
    <div class="row g-3">
        {{-- Panel stok menipis --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6 mb-2">Stok Menipis</h2>
                    @if($lowStockProducts->isEmpty())
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                            Belum ada produk dengan stok menipis.
                        </p>
                    @else
                        <p class="text-muted" style="font-size: 0.85rem;">
                            Produk dengan stok &le; 3. Pertimbangkan untuk restock.
                        </p>
                        <ul class="list-group list-group-flush">
                            @foreach($lowStockProducts as $p)
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div style="font-size: 0.9rem;">{{ $p->name }}</div>
                                        <small class="text-muted">
                                            Kategori: {{ $p->category?->name ?? '-' }}
                                        </small>
                                    </div>
                                    <span class="badge bg-warning text-dark">Stok: {{ $p->stock }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        {{-- Panel pesanan terbaru --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 mb-0">Pesanan Terbaru</h2>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                    @if($recentOrders->isEmpty())
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                            Belum ada pesanan yang dicatat.
                        </p>
                    @else
                        <p class="text-muted mb-3" style="font-size: 0.85rem;">
                            5 pesanan yang terakhir dicatat.
                        </p>
                        <ul class="list-group list-group-flush">
                            @foreach($recentOrders as $order)
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <div style="font-size: 0.9rem; font-weight: 500;">{{ $order->customer_name }}</div>
                                        <small class="text-muted d-block">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </small>
                                        <small class="badge {{ $order->getStatusBadgeClass() }} mt-1">
                                            {{ $order->getStatusLabel() }}
                                        </small>
                                    </div>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary ms-2">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection