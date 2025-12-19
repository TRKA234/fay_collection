@extends('layouts.front')
@section('title', 'Checkout')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card p-3" style="border-radius: 18px;">
            <h5 class="mb-3">Data Pengiriman</h5>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input class="form-control" name="customer_name"
                           value="{{ old('customer_name', auth()->user()->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">No. WhatsApp</label>
                    <input class="form-control" name="customer_contact"
                           value="{{ old('customer_contact') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Pengiriman</label>
                    <textarea class="form-control" name="shipping_address" rows="4" required>{{ old('shipping_address') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan (opsional)</label>
                    <textarea class="form-control" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>

                <button class="btn btn-primary w-100">Buat Pesanan</button>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card p-3" style="border-radius: 18px;">
            <h5 class="mb-3">Ringkasan Pesanan</h5>

            @foreach($cartItems as $row)
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <div class="fw-semibold">{{ $row['product']->name }}</div>
                        <small class="text-muted">
                            {{ $row['quantity'] }} x Rp {{ number_format($row['product']->price, 0, ',', '.') }}
                        </small>
                    </div>
                    <div class="fw-semibold">
                        Rp {{ number_format($row['subtotal'], 0, ',', '.') }}
                    </div>
                </div>
                <hr class="my-2">
            @endforeach

            <div class="d-flex justify-content-between">
                <div class="fw-bold">Total</div>
                <div class="fw-bold text-success">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </div>
            </div>

            <a href="{{ route('cart.index') }}" class="btn btn-outline-dark btn-sm mt-3">
                Kembali ke Keranjang
            </a>
        </div>
    </div>
</div>
@endsection
