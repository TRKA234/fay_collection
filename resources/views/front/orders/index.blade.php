@extends('layouts.front')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Pesanan Saya</h1>
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali Belanja
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="card text-center py-5">
            <div class="card-body">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📦</div>
                <h3 class="h5 mb-2">Belum Ada Pesanan</h3>
                <p class="text-muted mb-3">Mulai berbelanja dan buat pesanan pertama Anda!</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    Lihat Produk
                </a>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Kontak</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td><strong>#{{ $order->id }}</strong></td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $order->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong class="price-text">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge {{ $order->getStatusBadgeClass() }}">
                                            {{ $order->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $order->customer_contact }}</small>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection

