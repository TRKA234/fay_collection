@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none" style="font-size: 0.9rem;">
                &larr; Kembali ke daftar kategori
            </a>
            <h1 class="h4 mt-2 mb-1">Edit Kategori: {{ $category->name }}</h1>
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
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required autofocus>
                    <small class="text-muted">Slug akan otomatis diperbarui saat nama diubah</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection