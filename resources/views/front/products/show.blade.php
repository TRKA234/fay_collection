@extends('layouts.front')

@section('title', $product->name)

@section('content')
    <a href="{{ route('home') }}" class="text-decoration-none" style="font-size: 0.9rem;">
        &larr; Kembali ke beranda
    </a>

    <div class="row mt-3 g-4">
        <div class="col-md-5">
            {{-- Gambar besar di halaman detail --}}
            <div class="product-image-placeholder mb-2"
                 style="height: 320px; border-radius: 24px; overflow:hidden;">
                @if($product->main_image)
                    <img
                        src="{{ asset('storage/' . $product->main_image) }}"
                        alt="{{ $product->name }}"
                        style="width: 100%; height: 100%; object-fit: cover; display:block;"
                    >
                @else
                    <div class="d-flex align-items-center justify-content-center w-100 h-100"
                         style="border-radius: 24px; background: linear-gradient(135deg,#eef2ff,#fae8ff); color:#9ca3af;">
                        Belum ada gambar
                    </div>
                @endif
            </div>
            <small class="text-muted">
                *Foto produk bisa diperbarui melalui halaman admin.
            </small>
        </div>

        <div class="col-md-7">
            @if($product->category)
                <span class="category-pill mb-2 d-inline-flex">
                    <span class="category-pill-dot"></span>
                    {{ $product->category->name }}
                </span>
            @endif

            <h1 class="h4 mt-1">{{ $product->name }}</h1>

            <p class="price-text fs-4 mb-1">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            <p class="text-muted mb-2" style="font-size: 0.9rem;">
                Stok tersedia: {{ $product->stock }}
            </p>

            <p style="font-size: 0.95rem;">
                {{ $product->description ?: 'Belum ada deskripsi untuk produk ini.' }}
            </p>

            <div class="mt-3 d-flex flex-wrap gap-2">
                <a href="https://wa.me/62XXXXXXXXXX?text=Halo%20Fay%2C%20saya%20tertarik%20dengan%20{{ urlencode($product->name) }}"
                   class="btn btn-primary">
                    Pesan via WhatsApp
                </a>
                <button type="button" class="btn btn-outline-dark btn-sm" disabled>
                    Tambah ke keranjang (coming soon)
                </button>
            </div>
        </div>
    </div>
@endsection
