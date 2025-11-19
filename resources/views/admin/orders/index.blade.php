@extends('layouts.admin')

@section('title', 'Catatan Pesanan')

@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Catatan Pesanan</h1>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Daftar semua pesanan yang telah dicatat. Catat pesanan baru dari WhatsApp atau media lainnya.
            </p>
        </div>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
            + Catat Pesanan Baru
        </a>
    </div>

    {{-- Notif --}}
    @if(session('success'))
        <div class="alert alert-success py-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Status --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.index') }}"
                class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">
                Semua
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                Menunggu
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}"
                class="btn btn-sm {{ request('status') == 'paid' ? 'btn-info' : 'btn-outline-info' }}">
                Sudah Dibayar
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}"
                class="btn btn-sm {{ request('status') == 'completed' ? 'btn-success' : 'btn-outline-success' }}">
                Selesai
            </a>
        </div>
        <div class="text-muted" style="font-size: 0.85rem;">
            Total: <strong>{{ $orders->total() }}</strong> pesanan
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card">
        @if($orders->isEmpty())
            <div class="card-body text-center">
                <p class="mb-0">Belum ada pesanan yang dicatat. Klik tombol "Catat Pesanan Baru" untuk menambah pesanan pertama.
                </p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>Nama Pembeli</th>
                            <th>Kontak</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $orders->firstItem() + $loop->index }}</td>
                                <td>
                                    <div style="font-size: 0.95rem; font-weight: 500;">
                                        {{ $order->customer_name }}
                                    </div>
                                </td>
                                <td>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_contact) }}"
                                        target="_blank" class="text-decoration-none">
                                        {{ $order->customer_contact }}
                                        <i class="bi bi-box-arrow-up-right" style="font-size: 0.7rem;"></i>
                                    </a>
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <span class="badge {{ $order->getStatusBadgeClass() }}">
                                        {{ $order->getStatusLabel() }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-outline-secondary">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="card-footer">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection