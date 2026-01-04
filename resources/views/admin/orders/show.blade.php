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
                <i class="bi bi-pencil me-1"></i>Edit Pesanan
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

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
                        @if($order->user && $order->user->whatsapp)
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-person me-1"></i>
                                WhatsApp terdaftar: {{ $order->user->whatsapp }}
                            </small>
                        @endif
                    </div>

                    @if($order->notes)
                        <div class="mb-3">
                            <label class="text-muted" style="font-size: 0.85rem;">Catatan</label>
                            <div style="font-size: 0.95rem;">{{ $order->notes }}</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Informasi Pengiriman --}}
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="mb-3">Informasi Pengiriman</h5>

                    <div class="mb-3">
                        <label class="text-muted" style="font-size: 0.85rem;">Metode Pengiriman</label>
                        <div style="font-size: 1rem; font-weight: 500;">
                            <span class="badge {{ $order->shipping_method == 'jnt' ? 'bg-primary' : 'bg-success' }}">
                                {{ $order->getShippingMethodLabel() }}
                            </span>
                        </div>
                    </div>

                    @if($order->shipping_method == 'jnt')
                        <div class="mb-3">
                            <label class="text-muted" style="font-size: 0.85rem;">Alamat Pengiriman</label>
                            <div style="font-size: 0.95rem; white-space: pre-line;">{{ $order->shipping_address ?? '-' }}</div>
                        </div>
                    @else
                        <div class="mb-3">
                            <label class="text-muted" style="font-size: 0.85rem;">Lokasi Pengambilan</label>
                            <div style="font-size: 0.95rem;">
                                <i class="bi bi-geo-alt me-1"></i>
                                Ambil langsung di lokasi produksi (alamat akan dikirim via WhatsApp)
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="text-muted" style="font-size: 0.85rem;">Ongkos Kirim</label>
                        <div id="shippingCostDisplay">
                            @if($order->shipping_cost > 0)
                                <div style="font-size: 1rem; font-weight: 500;">
                                    Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                </div>
                            @else
                                <div class="alert alert-warning py-2" style="font-size: 0.85rem;">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    <strong>Belum diisi!</strong>
                                </div>
                            @endif
                        </div>
                        
                        <form id="updateShippingCostForm" class="mt-2">
                            @csrf
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                    id="shippingCostInput" 
                                    class="form-control" 
                                    value="{{ $order->shipping_cost }}" 
                                    min="0" 
                                    placeholder="Masukkan ongkos kirim"
                                    style="max-width: 150px;">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-check-lg"></i> Update
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-info-circle me-1"></i>
                                Update ongkos kirim dan total pesanan akan otomatis terupdate
                            </small>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Informasi Pembayaran --}}
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="mb-3">Informasi Pembayaran</h5>

                    <div class="mb-3">
                        <label class="text-muted" style="font-size: 0.85rem;">Metode Pembayaran</label>
                        <div style="font-size: 1rem; font-weight: 500;">{{ ucfirst($order->payment_method ?? 'Transfer') }}</div>
                    </div>

                    @if($order->payment_info)
                        <div class="mb-3">
                            <label class="text-muted" style="font-size: 0.85rem;">Informasi Rekening/Instruksi</label>
                            <div style="font-size: 0.95rem; white-space: pre-line;">{{ $order->payment_info }}</div>
                        </div>
                    @else
                        <div class="mb-3">
                            <div class="alert alert-warning py-2" style="font-size: 0.85rem;">
                                <i class="bi bi-info-circle me-1"></i>
                                Informasi pembayaran belum diisi. Tambahkan melalui edit pesanan.
                            </div>
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
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">
                                        <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Ongkos Kirim:</strong></td>
                                    <td class="text-end" id="shippingCostTable">
                                        <strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Total Pesanan:</th>
                                    <th class="text-end text-primary" style="font-size: 1.1rem;" id="totalWithShippingTable">
                                        Rp {{ number_format($order->getTotalWithShipping(), 0, ',', '.') }}
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
                    <h5 class="mb-3">Ubah Status</h5>

                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-sm status-change-btn {{ $order->status == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}" 
                            data-status="pending" data-status-label="Menunggu">
                            <span class="badge bg-warning text-dark me-2">Menunggu</span> Set Menunggu
                        </button>
                        <button class="btn btn-sm status-change-btn {{ $order->status == 'paid' ? 'btn-info' : 'btn-outline-info' }}" 
                            data-status="paid" data-status-label="Sudah Dibayar">
                            <span class="badge bg-info text-dark me-2">Sudah Dibayar</span> Set Sudah Dibayar
                        </button>
                        <button class="btn btn-sm status-change-btn {{ $order->status == 'shipped' ? 'btn-primary' : 'btn-outline-primary' }}" 
                            data-status="shipped" data-status-label="Dikirim">
                            <span class="badge bg-primary me-2">Dikirim</span> Set Dikirim
                        </button>
                        <button class="btn btn-sm status-change-btn {{ $order->status == 'completed' ? 'btn-success' : 'btn-outline-success' }}" 
                            data-status="completed" data-status-label="Selesai">
                            <span class="badge bg-success me-2">Selesai</span> Set Selesai
                        </button>
                        <button class="btn btn-sm status-change-btn {{ $order->status == 'cancelled' ? 'btn-danger' : 'btn-outline-danger' }}" 
                            data-status="cancelled" data-status-label="Dibatalkan">
                            <span class="badge bg-danger me-2">Dibatalkan</span> Set Dibatalkan
                        </button>
                    </div>

                    <hr>

                    <h5 class="mb-3">Aksi Lainnya</h5>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i>Edit Pesanan
                        </a>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus pesanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger w-100">
                                <i class="bi bi-trash me-1"></i>Hapus Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.status-change-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const status = this.dataset.status;
                    const statusLabel = this.dataset.statusLabel;
                    
                    if (!confirm('Yakin ingin mengubah status pesanan menjadi "' + statusLabel + '"?')) {
                        return;
                    }
                    
                    // Show loading
                    const originalText = this.innerHTML;
                    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengubah...';
                    this.disabled = true;
                    
                    // Send request
                    fetch('{{ route("admin.orders.update-status", $order->id) }}', {
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
                            // Update status badge
                            const statusBadge = document.querySelector('.badge.' + data.status_badge_class.split(' ')[0]);
                            if (statusBadge) {
                                statusBadge.className = 'badge ' + data.status_badge_class;
                                statusBadge.textContent = data.status_label;
                            }
                            
                            // Update button states
                            document.querySelectorAll('.status-change-btn').forEach(function(b) {
                                b.classList.remove('btn-warning', 'btn-info', 'btn-primary', 'btn-success', 'btn-danger');
                                b.classList.add('btn-outline-warning', 'btn-outline-info', 'btn-outline-primary', 'btn-outline-success', 'btn-outline-danger');
                            });
                            
                            // Highlight active button
                            this.classList.remove('btn-outline-warning', 'btn-outline-info', 'btn-outline-primary', 'btn-outline-success', 'btn-outline-danger');
                            if (status === 'pending') this.classList.add('btn-warning');
                            else if (status === 'paid') this.classList.add('btn-info');
                            else if (status === 'shipped') this.classList.add('btn-primary');
                            else if (status === 'completed') this.classList.add('btn-success');
                            else if (status === 'cancelled') this.classList.add('btn-danger');
                            
                            // Show success message
                            const alertDiv = document.createElement('div');
                            alertDiv.className = 'alert alert-success py-2 mb-3';
                            alertDiv.innerHTML = '<i class="bi bi-check-circle me-2"></i>' + data.message;
                            document.querySelector('.d-flex.justify-content-between').after(alertDiv);
                            
                            // Remove alert after 3 seconds
                            setTimeout(() => alertDiv.remove(), 3000);
                            
                            this.innerHTML = originalText;
                            this.disabled = false;
                        } else {
                            alert('Gagal mengubah status pesanan.');
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah status pesanan.');
                        this.innerHTML = originalText;
                        this.disabled = false;
                    });
                });
            });

            // Update Shipping Cost
            document.getElementById('updateShippingCostForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const shippingCost = parseInt(document.getElementById('shippingCostInput').value) || 0;
                const orderId = {{ $order->id }};
                
                if (shippingCost < 0) {
                    alert('Ongkos kirim tidak boleh negatif');
                    return;
                }
                
                // Show loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Updating...';
                submitBtn.disabled = true;
                
                // Send request
                fetch('/admin/orders/' + orderId + '/update-shipping-cost', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ shipping_cost: shippingCost })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Gagal mengupdate ongkos kirim');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update display
                        const shippingCostDisplay = document.getElementById('shippingCostDisplay');
                        if (shippingCostDisplay) {
                            if (shippingCost > 0) {
                                shippingCostDisplay.innerHTML = '<div style="font-size: 1rem; font-weight: 500;">Rp ' + 
                                    new Intl.NumberFormat('id-ID').format(shippingCost) + '</div>';
                            } else {
                                shippingCostDisplay.innerHTML = '<div class="alert alert-warning py-2" style="font-size: 0.85rem;">' +
                                    '<i class="bi bi-exclamation-triangle me-1"></i><strong>Belum diisi!</strong></div>';
                            }
                        }
                        
                        // Update table
                        const shippingCostTable = document.getElementById('shippingCostTable');
                        if (shippingCostTable) {
                            shippingCostTable.innerHTML = 
                                '<strong>Rp ' + new Intl.NumberFormat('id-ID').format(shippingCost) + '</strong>';
                        }
                        
                        const totalWithShippingTable = document.getElementById('totalWithShippingTable');
                        if (totalWithShippingTable) {
                            const totalWithShipping = {{ $order->total_amount }} + shippingCost;
                            totalWithShippingTable.innerHTML = 
                                'Rp ' + new Intl.NumberFormat('id-ID').format(totalWithShipping);
                        }
                        
                        // Show success message
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success py-2 mb-3';
                        alertDiv.innerHTML = '<i class="bi bi-check-circle me-2"></i>' + data.message;
                        document.querySelector('.d-flex.justify-content-between').after(alertDiv);
                        
                        // Remove alert after 3 seconds
                        setTimeout(() => alertDiv.remove(), 3000);
                    } else {
                        alert('Gagal mengupdate ongkos kirim: ' + (data.message || 'Unknown error'));
                    }
                    
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        });
    </script>
@endsection