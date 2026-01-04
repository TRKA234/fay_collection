@extends('layouts.admin')

@section('title', 'Edit Pesanan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none" style="font-size: 0.9rem;">
                &larr; Kembali ke daftar pesanan
            </a>
            <h1 class="h4 mt-2 mb-1">Edit Pesanan #{{ $order->id }}</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger py-2 mb-3">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" id="orderForm">
                @csrf
                @method('PUT')

                {{-- Informasi Pembeli --}}
                <div class="mb-4">
                    <h5 class="mb-3">Informasi Pembeli</h5>

                    <div class="mb-3">
                        <label class="form-label">Nama Pembeli <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control"
                            value="{{ old('customer_name', $order->customer_name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="customer_contact" class="form-control"
                            value="{{ old('customer_contact', $order->customer_contact) }}" required>
                    </div>
                </div>

                {{-- Informasi Pengiriman --}}
                <div class="mb-4">
                    <h5 class="mb-3">Informasi Pengiriman</h5>

                    <div class="mb-3">
                        <label class="form-label">Metode Pengiriman <span class="text-danger">*</span></label>
                        <select name="shipping_method" id="shippingMethod" class="form-select" required>
                            <option value="jnt" {{ old('shipping_method', $order->shipping_method) == 'jnt' ? 'selected' : '' }}>JNT Express (Pengiriman)</option>
                            <option value="pickup" {{ old('shipping_method', $order->shipping_method) == 'pickup' ? 'selected' : '' }}>Ambil di Lokasi Produksi</option>
                        </select>
                    </div>

                    <div class="mb-3" id="shippingAddressGroup">
                        <label class="form-label">Alamat Pengiriman Lengkap <span class="text-danger">*</span></label>
                        <textarea name="shipping_address" class="form-control" rows="3"
                            placeholder="Nama Penerima, Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ongkos Kirim (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="shipping_cost" class="form-control"
                            value="{{ old('shipping_cost', $order->shipping_cost) }}" min="0" required>
                    </div>
                </div>

                {{-- Informasi Pembayaran --}}
                <div class="mb-4">
                    <h5 class="mb-3">Informasi Pembayaran</h5>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <input type="text" name="payment_method" class="form-control"
                            value="{{ old('payment_method', $order->payment_method ?? 'transfer') }}" placeholder="Contoh: Transfer, Cash, dll">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Informasi Rekening/Instruksi Pembayaran</label>
                        <textarea name="payment_info" class="form-control" rows="4"
                            placeholder="Contoh:&#10;Bank: BCA&#10;No. Rekening: 1234567890&#10;Atas Nama: Fay Collection&#10;&#10;Atau instruksi pembayaran lainnya...">{{ old('payment_info', $order->payment_info) }}</textarea>
                        <small class="text-muted">Informasi ini akan dikirim ke customer melalui email dan WhatsApp</small>
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <h5 class="mb-3">Status Pesanan</h5>
                    <select name="status" class="form-select" required>
                        <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Menunggu
                        </option>
                        <option value="paid" {{ old('status', $order->status) == 'paid' ? 'selected' : '' }}>Sudah Dibayar
                        </option>
                        <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Dikirim
                        </option>
                        <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Selesai
                        </option>
                        <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>
                            Dibatalkan</option>
                    </select>
                </div>

                {{-- Produk yang Dipesan --}}
                <div class="mb-4">
                    <h5 class="mb-3">Produk yang Dipesan</h5>
                    <div id="productsContainer">
                        {{-- Produk akan ditambahkan via JavaScript --}}
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="addProductBtn">
                        + Tambah Produk
                    </button>
                </div>

                {{-- Catatan --}}
                <div class="mb-3">
                    <label class="form-label">Catatan (Opsional)</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $order->notes) }}</textarea>
                </div>

                {{-- Total --}}
                <div class="mb-3 p-3 bg-light rounded">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Total Pesanan:</strong>
                        <strong class="text-primary" id="totalAmount">Rp 0</strong>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-dark">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let productIndex = 0;
        const products = @json($products);
        const orderProducts = @json($order->products->map(function ($product) {
            return [
                'id' => $product->id,
                'quantity' => $product->pivot->quantity
            ];
        })->values());

        document.getElementById('addProductBtn').addEventListener('click', function () {
            addProductRow();
        });

        function addProductRow(productId = '', quantity = 1) {
            const container = document.getElementById('productsContainer');
            const row = document.createElement('div');
            row.className = 'row mb-3 product-row';
            row.dataset.index = productIndex;

            row.innerHTML = `
                                <div class="col-md-6">
                                    <select name="products[${productIndex}][id]" class="form-select product-select" required>
                                        <option value="">-- Pilih Produk --</option>
                                        ${products.map(p => `
                                            <option value="${p.id}" data-price="${p.price}" ${p.id == productId ? 'selected' : ''}>
                                                ${p.name} - Rp ${new Intl.NumberFormat('id-ID').format(p.price)}
                                            </option>
                                        `).join('')}
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="products[${productIndex}][quantity]"
                                           class="form-control product-quantity"
                                           value="${quantity}" min="1" required>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-control-plaintext subtotal" style="font-weight: 600;">
                                        Rp 0
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-product">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;

            container.appendChild(row);

            // Event listeners
            const select = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.product-quantity');
            const removeBtn = row.querySelector('.remove-product');

            select.addEventListener('change', calculateTotal);
            quantityInput.addEventListener('input', calculateTotal);
            removeBtn.addEventListener('click', function () {
                row.remove();
                calculateTotal();
            });

            productIndex++;
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.product-row').forEach(row => {
                const select = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.product-quantity');
                const subtotalEl = row.querySelector('.subtotal');

                if (select.value && quantityInput.value) {
                    const option = select.options[select.selectedIndex];
                    const price = parseFloat(option.dataset.price) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    const subtotal = price * quantity;

                    subtotalEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
                    total += subtotal;
                } else {
                    subtotalEl.textContent = 'Rp 0';
                }
            });

            document.getElementById('totalAmount').textContent =
                'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        // Load existing products
        if (orderProducts && orderProducts.length > 0) {
            orderProducts.forEach(function (item) {
                addProductRow(item.id, item.quantity);
            });
        } else {
            // If no products, add one empty row
            addProductRow();
        }
    </script>
@endsection