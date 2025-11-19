@extends('layouts.front')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Keranjang Belanja</h1>
        @if(count($cartItems) > 0)
            <form action="{{ route('cart.clear') }}" method="POST"
                onsubmit="return confirm('Yakin ingin mengosongkan keranjang?')">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    Kosongkan Keranjang
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger py-2 mb-3">
            {{ session('error') }}
        </div>
    @endif

    @if(count($cartItems) == 0)
        <div class="card text-center py-5">
            <div class="card-body">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🛒</div>
                <h3 class="h5 mb-2">Keranjang Anda Kosong</h3>
                <p class="text-muted mb-3">Mulai berbelanja dan tambahkan produk ke keranjang Anda!</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    Lihat Produk
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            {{-- Daftar Produk --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Produk di Keranjang</h5>

                        @foreach($cartItems as $item)
                            <div class="d-flex gap-3 mb-4 pb-4 border-bottom">
                                {{-- Gambar Produk --}}
                                <div style="width: 100px; height: 100px; flex-shrink: 0; border-radius: 12px; overflow: hidden;">
                                    @if($item['product']->main_image)
                                        <img src="{{ asset('storage/' . $item['product']->main_image) }}"
                                            alt="{{ $item['product']->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center w-100 h-100 bg-light text-muted">
                                            <small>No Image</small>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info Produk --}}
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="{{ route('product.show', $item['product']->slug) }}"
                                            class="text-decoration-none text-reset">
                                            {{ $item['product']->name }}
                                        </a>
                                    </h6>
                                    @if($item['product']->category)
                                        <small class="text-muted">{{ $item['product']->category->name }}</small>
                                    @endif
                                    <div class="mt-2">
                                        <span class="price-text">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</span>
                                        <small class="text-muted">/ item</small>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">Stok: {{ $item['product']->stock }}</small>
                                    </div>
                                </div>

                                {{-- Quantity & Actions --}}
                                <div class="text-end">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <form action="{{ route('cart.update', $item['product']) }}" method="POST"
                                            class="d-flex align-items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                                max="{{ $item['product']->stock }}" class="form-control form-control-sm"
                                                style="width: 70px;" onchange="this.form.submit()">
                                        </form>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="price-text">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</strong>
                                    </div>
                                    <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Ringkasan & Checkout --}}
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 100px;">
                    <div class="card-body">
                        <h5 class="mb-3">Ringkasan Pesanan</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal ({{ count($cartItems) }} item):</span>
                            <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="price-text fs-5">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>

                        {{-- Generate WhatsApp Message --}}
                        @php
                            $waMessage = "Halo Fay Collection!%0A%0A";
                            $waMessage .= "Saya ingin memesan:%0A%0A";
                            foreach ($cartItems as $item) {
                                $waMessage .= "• " . $item['product']->name . " (x" . $item['quantity'] . ") - Rp " . number_format($item['subtotal'], 0, ',', '.') . "%0A";
                            }
                            $waMessage .= "%0ATotal: Rp " . number_format($total, 0, ',', '.') . "%0A%0A";
                            $waMessage .= "Terima kasih!";
                            // Ganti dengan nomor WhatsApp admin yang sebenarnya (format: 6285172343199 tanpa + atau spasi)
                            $waNumber = "6285172343199";
                        @endphp

                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank"
                            class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-whatsapp"></i> Checkout via WhatsApp
                        </a>

                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                            Lanjutkan Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
