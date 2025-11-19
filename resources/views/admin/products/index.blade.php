@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Kelola Produk</h1>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Daftar seluruh produk Fay Collection. Anda dapat menambah, mengubah, atau menghapus produk di sini.
            </p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            + Tambah Produk
        </a>
    </div>

    {{-- Notif --}}
    @if(session('success'))
        <div class="alert alert-success py-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- Info kecil & pencarian sederhana (opsional, tanpa logic filter dulu) --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-muted" style="font-size: 0.85rem;">
            Total: <strong>{{ $products->total() }}</strong> produk
        </div>
        <form method="GET" class="d-flex gap-1" style="max-width: 260px;">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari nama produk..."
                value="{{ request('q') }}">
            <button class="btn btn-outline-secondary btn-sm">Cari</button>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="card">
        @if($products->isEmpty())
            <div class="card-body text-center">
                <p class="mb-0">Belum ada produk. Klik tombol "Tambah Produk" untuk membuat produk pertama.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $products->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span style="font-size: 0.95rem; font-weight: 500;">
                                            {{ $product->name }}
                                        </span>
                                        <small class="text-muted">{{ $product->slug }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle border text-secondary" style="font-size: 0.75rem;">
                                        {{ $product->category?->name ?? '-' }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $stock = $product->stock;
                                        $stockClass = $stock <= 3 ? 'bg-danger' : ($stock <= 10 ? 'bg-warning text-dark' : 'bg-success');
                                    @endphp
                                    <span class="badge {{ $stockClass }}">{{ $stock }}</span>
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="card-footer">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection