@extends('layouts.front')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('orders.index') }}" class="text-decoration-none" style="font-size: 0.9rem;">
                &larr; Kembali ke daftar pesanan
            </a>
            <h1 class="h4 mt-2 mb-1">Detail Pesanan #{{ $order->id }}</h1>
        </div>
    </div>

    <div class="row g-3">
        {{-- Informasi Pesanan --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Informasi Pesanan</h5>

                    <div class="mb-3">
                        <label class="text-muted" style="font-size: 0.85rem;">Nama</label>
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

                    @if($order->shipping_method == 'jnt' && $order->shipping_address)
                        <div class="mb-3">
                            <label class="text-muted" style="font-size: 0.85rem;">Alamat Pengiriman</label>
                            <div style="font-size: 0.95rem; white-space: pre-line;">{{ $order->shipping_address }}</div>
                        </div>
                    @elseif($order->shipping_method == 'pickup')
                        <div class="mb-3">
                            <label class="text-muted" style="font-size: 0.85rem;">Lokasi Pengambilan</label>
                            <div style="font-size: 0.95rem;">
                                <i class="bi bi-geo-alt me-1"></i>
                                Ambil langsung di lokasi produksi. Admin akan mengirimkan alamat lengkap via WhatsApp.
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="text-muted" style="font-size: 0.85rem;">Ongkos Kirim</label>
                        @if($order->shipping_cost > 0)
                            <div style="font-size: 1rem; font-weight: 500;">
                                Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                            </div>
                        @else
                            <div style="font-size: 0.95rem; color: #666;">
                                <i class="bi bi-clock me-1"></i>
                                Menunggu konfirmasi admin. Admin akan menghubungi Anda via WhatsApp untuk konfirmasi ongkos kirim.
                            </div>
                        @endif
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
                            <label class="text-muted" style="font-size: 0.85rem;">Informasi Rekening/Instruksi Pembayaran</label>
                            <div style="font-size: 0.95rem; white-space: pre-line; background-color: #f8f9fa; padding: 15px; border-radius: 8px;">
                                {{ $order->payment_info }}
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info py-2" style="font-size: 0.85rem;">
                            <i class="bi bi-info-circle me-1"></i>
                            Admin akan mengirimkan informasi rekening dan instruksi pembayaran melalui WhatsApp atau email setelah pesanan dikonfirmasi.
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
                                    <td colspan="3" class="text-end">
                                        <strong>Ongkos Kirim:</strong>
                                        @if($order->shipping_cost == 0)
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">Menunggu konfirmasi</small>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($order->shipping_cost > 0)
                                            <strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Total Pesanan:</th>
                                    <th class="text-end price-text" style="font-size: 1.1rem;">
                                        @if($order->shipping_cost > 0)
                                            Rp {{ number_format($order->getTotalWithShipping(), 0, ',', '.') }}
                                        @else
                                            <span style="font-size: 0.9rem; color: #666;">
                                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                                <small class="d-block" style="font-size: 0.7rem;">+ ongkos kirim</small>
                                            </span>
                                        @endif
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
                    <h5 class="mb-3">Butuh Bantuan?</h5>
                    <p class="text-muted" style="font-size: 0.9rem;">
                        Jika ada pertanyaan tentang pesanan Anda, silakan hubungi admin melalui WhatsApp.
                    </p>
                    <a href="https://wa.me/6285172343199" target="_blank" class="btn btn-success w-100">
                        <i class="bi bi-whatsapp"></i> Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

