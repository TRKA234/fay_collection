@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none" style="font-size: 0.9rem;">
                &larr; Kembali ke daftar produk
            </a>
            <h1 class="h4 mt-2 mb-1">Edit Produk: {{ $product->name }}</h1>
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
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.products._form', ['product' => $product])
            </form>
        </div>
    </div>
@endsection