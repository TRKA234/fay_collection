@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Kelola Kategori</h1>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Daftar kategori produk. Anda dapat menambah, mengubah, atau menghapus kategori di sini.
            </p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            + Tambah Kategori
        </a>
    </div>

    {{-- Notif --}}
    @if(session('success'))
        <div class="alert alert-success py-2">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger py-2">
            {{ session('error') }}
        </div>
    @endif

    {{-- Info kecil --}}
    <div class="text-muted mb-3" style="font-size: 0.85rem;">
        Total: <strong>{{ $categories->total() }}</strong> kategori
    </div>

    {{-- Tabel --}}
    <div class="card">
        @if($categories->isEmpty())
            <div class="card-body text-center">
                <p class="mb-0">Belum ada kategori. Klik tombol "Tambah Kategori" untuk membuat kategori pertama.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah Produk</th>
                            <th>Slug</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $categories->firstItem() + $loop->index }}</td>
                                <td>
                                    <div style="font-size: 0.95rem; font-weight: 500;">
                                        {{ $category->name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $category->products_count }} produk
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $category->slug }}</small>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus kategori ini?')">
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

            @if($categories->hasPages())
                <div class="card-footer">
                    {{ $categories->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection