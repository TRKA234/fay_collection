@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <h1 class="h4 mb-3">Edit Kategori: {{ $category->name }}</h1>

    @if($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0">
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
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                    <small class="text-muted">Slug akan otomatis diperbarui saat nama diubah</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection