@extends('layouts.front')

@section('title', 'Register')

@section('content')
<div class="container py-5" style="max-width: 520px">
    <h3 class="mb-4 text-center">Daftar Akun Pembeli</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                required
            >
        </div>

        <button class="btn btn-success w-100">
            Daftar
        </button>

        <div class="text-center mt-3">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login</a>
        </div>
    </form>
</div>
@endsection
