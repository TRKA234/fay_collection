@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none" style="font-size: 0.9rem;">
                &larr; Kembali ke daftar pesanan
            </a>
            <h1 class="h4 mt-2 mb-1">Detail Pesanan #{{ $order->id }}</h1>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary">
                Edit Pesanan
            </a>
        </div>
    </div>

    <div class="row g-3">
        {{-- Informasi Pesanan --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Informasi Pembeli</h5>

                    <div class="mb-3">
                        <label class="text-muted" style="font-size: 0.85rem;">Nama Pembeli</label>
                        <div style="font-size: 1rem; font-weight: 500;">{{ $order->customer_name }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted" style="font-size: 0.85rem;">Kontak WhatsApp</label>
                        <div>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_contact) }}"
                                target="_blank" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-whatsapp"></i> {{ $order->customer_contact }}
                            </a>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="mb-3">
                            <label class="text-muted" style="font-size: 0.85rem;">Catatan</label>
                            <div style="font-size: 0.95rem;">{{ $order->notes }}</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Daftar Produk --}}
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="mb-3">Produk yang Dipesan</h5>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->products as $product)
                                    <tr>
                                        <td>
                                            <div style="font-weight: 500;">{{ $product->name }}</div>
                                            @if($product->category)
                                                <small class="text-muted">{{ $product->category->name }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                                        <td class="text-end">Rp {{ number_format($product->pivot->price, 0, ',', '.') }}</td>
                                        <td class="text-end">
                                            <strong>Rp
                                                {{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total Pesanan:</th>
                                    <th class="text-end text-primary" style="font-size: 1.1rem;">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Status Pesanan</h5>

                    <div class="mb-3">
                        <span class="badge {{ $order->getStatusBadgeClass() }}"
                            style="font-size: 0.9rem; padding: 8px 12px;">
                            {{ $order->getStatusLabel() }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted" style="font-size: 0.85rem;">Tanggal Pesanan</label>
                        <div style="font-size: 0.95rem;">
                            {{ $order->created_at->format('d F Y, H:i') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted" style="font-size: 0.85rem;">Terakhir Diupdate</label>
                        <div style="font-size: 0.95rem;">
                            {{ $order->updated_at->format('d F Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="mb-3">Aksi</h5>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary">
                            Edit Pesanan
                        </a>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus pesanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger w-100">
                                Hapus Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection