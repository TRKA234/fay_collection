@extends('layouts.admin_noside')

@section('title', 'Login Admin')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h3 class="h4 mb-1">Login Admin</h3>
                        <p class="text-muted small mb-0">Masuk ke panel administrasi</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger py-2">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email', 'admin@faycollection.test') }}"
                                required
                                autofocus
                                placeholder="admin@faycollection.test"
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

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                        </button>

                        <div class="text-center">
                            <small class="text-muted">
                                <a href="{{ route('home') }}" class="text-decoration-none">
                                    <i class="bi bi-arrow-left me-1"></i>Kembali ke website
                                </a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection