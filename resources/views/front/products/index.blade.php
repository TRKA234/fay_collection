@extends('layouts.front')

@section('title', 'Beranda')

@section('content')
    {{-- Hero section --}}
    <div class="hero-section mb-4 mb-md-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="pill-soft">
                        <span class="pill-soft-dot"></span>
                        Koleksi baru setiap bulan
                    </div>
                </div>
                <h1 class="hero-title">
                    Aksesoris rajut handmade<br>untuk melengkapi gaya harianmu.
                </h1>
                <p class="hero-subtitle mt-2">
                    Tas rajut, sepatu, gantungan kunci, kotak tisu, dan banyak lagi —
                    semua dibuat dengan tangan, detail, dan cinta. Satu per satu, bukan produksi massal.
                </p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <a href="#product-list" class="btn btn-primary">
                        Jelajahi Koleksi
                    </a>
                    <a href="https://wa.me/6285172343199" class="btn btn-outline-dark btn-sm">
                        Tanya dulu via WhatsApp
                    </a>
                </div>
            </div>

            {{-- Hero preview di kanan --}}
            <div class="col-lg-5">
                <div class="product-image-placeholder d-flex align-items-center justify-content-center text-muted">
                    {{-- Nanti bisa diganti foto beneran --}}
                    Preview koleksi Fay Collection
                </div>
            </div>
        </div>
    </div>

    {{-- List produk --}}
    <div class="mb-3" id="product-list">
        <div class="d-flex justify-content-between align-items-baseline mb-3">
            <div>
                <h2 class="h5 mb-1">Produk Terbaru</h2>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">
                    Pilih produk rajut favoritmu. Cocok untuk hadiah atau koleksi pribadi.
                </p>
            </div>
            <span class="text-muted" style="font-size: 0.85rem;">
                {{ $products->count() }} produk
            </span>
        </div>

        {{-- Filter Kategori --}}
        @if($categories->isNotEmpty())
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="{{ route('home') }}"
                    class="btn btn-sm {{ !$selectedCategory ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Semua Kategori
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('home', ['category' => $category->slug]) }}"
                        class="btn btn-sm {{ $selectedCategory && $selectedCategory->id == $category->id ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    @if($products->isEmpty())
        <p>Belum ada produk yang aktif. Nanti kita buat halaman admin untuk menambah produk.</p>
    @else
        <div class="row g-3 g-md-4">
            @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-reset">
                        <div class="card product-card h-100">
                            <div class="p-2">
                                {{-- Gambar produk di kartu --}}
                                <div class="product-image-placeholder" style="height: 220px; border-radius: 22px; overflow:hidden;">
                                    @if($product->main_image)
                                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}"
                                            style="width: 100%; height: 100%; object-fit: cover; display:block;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center w-100 h-100"
                                            style="border-radius: 22px; background: linear-gradient(135deg,#eef2ff,#fae8ff); color:#9ca3af;">
                                            Belum ada gambar
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body pt-0 pb-3">
                                @if($product->category)
                                    <span class="category-pill mb-1">
                                        <span class="category-pill-dot"></span>
                                        {{ $product->category->name }}
                                    </span>
                                @endif

                                <h3 class="h6 mt-2 mb-1" style="min-height: 2.4em;">
                                    {{ $product->name }}
                                </h3>

                                <p class="mb-1 price-text">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                <small class="text-muted">
                                    Stok: {{ $product->stock }}
                                </small>

                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-2"
                                        onclick="event.stopPropagation();">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-sm btn-primary w-100">
                                            <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <div class="mt-2">
                                        <small class="text-danger">Stok habis</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
