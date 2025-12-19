@extends('layouts.front')

@section('title', 'Login')

@section('content')
<div class="container py-5" style="max-width: 480px">
    <h3 class="mb-4 text-center">Login Pembeli</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
                autofocus
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

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>
        </div>

        <button class="btn btn-primary w-100">
            Login
        </button>

        <div class="text-center mt-3">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </form>
</div>
@endsection
