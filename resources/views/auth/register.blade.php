@extends('layouts.front')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="h4 mb-1">Daftar Akun</h3>
                    <p class="text-muted small mb-0">Buat akun baru untuk mulai berbelanja</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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
                            autofocus
                            placeholder="Nama lengkap Anda"
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
                            placeholder="nama@email.com"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            name="whatsapp"
                            class="form-control"
                            value="{{ old('whatsapp') }}"
                            required
                            placeholder="081234567890 atau +6281234567890"
                        >
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Nomor WhatsApp untuk konfirmasi pesanan dan komunikasi
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required
                            placeholder="Minimal 6 karakter"
                        >
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            required
                            placeholder="Ulangi password"
                        >
                    </div>

                    <button class="btn btn-primary w-100 mb-3">
                        <i class="bi bi-person-plus me-2"></i>Daftar
                    </button>

                    <div class="text-center">
                        <small class="text-muted">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
