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
        <div class="alert alert-success py-2 mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-warning py-2 mb-3">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
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
            <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}"
                class="btn btn-sm {{ request('status') == 'shipped' ? 'btn-primary' : 'btn-outline-primary' }}">
                Dikirim
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
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                id="statusDropdown{{ $order->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Ubah Status
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="statusDropdown{{ $order->id }}">
                                                <li>
                                                    <a class="dropdown-item status-change" href="#" 
                                                        data-order-id="{{ $order->id }}" 
                                                        data-status="pending"
                                                        data-status-label="Menunggu">
                                                        <span class="badge bg-warning text-dark me-2">Menunggu</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item status-change" href="#" 
                                                        data-order-id="{{ $order->id }}" 
                                                        data-status="paid"
                                                        data-status-label="Sudah Dibayar">
                                                        <span class="badge bg-info text-dark me-2">Sudah Dibayar</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item status-change" href="#" 
                                                        data-order-id="{{ $order->id }}" 
                                                        data-status="shipped"
                                                        data-status-label="Dikirim">
                                                        <span class="badge bg-primary me-2">Dikirim</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item status-change" href="#" 
                                                        data-order-id="{{ $order->id }}" 
                                                        data-status="completed"
                                                        data-status-label="Selesai">
                                                        <span class="badge bg-success me-2">Selesai</span>
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item status-change text-danger" href="#" 
                                                        data-order-id="{{ $order->id }}" 
                                                        data-status="cancelled"
                                                        data-status-label="Dibatalkan">
                                                        <span class="badge bg-danger me-2">Dibatalkan</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.status-change').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const orderId = this.dataset.orderId;
                    const status = this.dataset.status;
                    const statusLabel = this.dataset.statusLabel;
                    
                    if (!confirm('Yakin ingin mengubah status pesanan menjadi "' + statusLabel + '"?')) {
                        return;
                    }
                    
                    // Show loading
                    const originalText = this.innerHTML;
                    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengubah...';
                    this.style.pointerEvents = 'none';
                    
                    // Send request
                    const updateUrl = '/admin/orders/' + orderId + '/update-status';
                    fetch(updateUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ status: status })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || 'Gagal mengubah status');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Reload page to show updated status
                            location.reload();
                        } else {
                            alert('Gagal mengubah status pesanan: ' + (data.message || 'Unknown error'));
                            this.innerHTML = originalText;
                            this.style.pointerEvents = 'auto';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah status pesanan: ' + error.message);
                        this.innerHTML = originalText;
                        this.style.pointerEvents = 'auto';
                    });
                });
            });
        });
    </script>
@endsection