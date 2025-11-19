@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <h1 class="h4 mb-3">Tambah Produk</h1>

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
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.products._form', ['product' => null])
            </form>
        </div>
    </div>
@endsection