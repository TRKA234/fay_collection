@extends('layouts.front')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="h4 mb-1">Login</h3>
                    <p class="text-muted small mb-0">
                        Masuk sebagai Customer atau Admin
                    </p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <i class="bi bi-exclamation-triangle me-2"></i>
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
                            placeholder="nama@email.com"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required
                            placeholder="Masukkan password"
                        >
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>

                    <div class="text-center mb-2">
                        <small class="text-muted">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-decoration-none">Daftar sekarang</a>
                        </small>
                    </div>

                    <hr class="my-3">

                    <div class="text-center">
                        <small class="text-muted d-block mb-1">
                            <i class="bi bi-info-circle me-1"></i>
                            Sistem akan otomatis mengarahkan Anda ke halaman yang sesuai berdasarkan role akun.
                        </small>
                        <small class="text-muted">
                            Admin? Login dengan email admin untuk akses panel.
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

