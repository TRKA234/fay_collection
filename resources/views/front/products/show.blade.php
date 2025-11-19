@extends('layouts.front')

@section('title', $product->name)

@section('content')
    <a href="{{ route('home') }}" class="text-decoration-none" style="font-size: 0.9rem;">
        &larr; Kembali ke beranda
    </a>

    <div class="row mt-3 g-4">
        <div class="col-md-5">
            {{-- Gambar besar di halaman detail --}}
            <div class="product-image-placeholder mb-2" style="height: 320px; border-radius: 24px; overflow:hidden;">
                @if($product->main_image)
                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}"
                        style="width: 100%; height: 100%; object-fit: cover; display:block;">
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

            @if($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-3">
                    @csrf
                    <div class="d-flex flex-wrap gap-2 align-items-end">
                        <div>
                            <label class="form-label small">Jumlah</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                class="form-control" style="width: 100px;" required>
                        </div>
                        <div class="flex-grow-1">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="alert alert-warning mt-3 py-2">
                    <small>Stok habis. Silakan hubungi kami untuk pre-order.</small>
                </div>
            @endif

            <div class="mt-2">
                <a href="https://wa.me/62XXXXXXXXXX?text=Halo%20Fay%2C%20saya%20tertarik%20dengan%20{{ urlencode($product->name) }}"
                    class="btn btn-outline-success btn-sm">
                    <i class="bi bi-whatsapp"></i> Tanya via WhatsApp
                </a>
            </div>
        </div>
    </div>
@endsection