@extends('layouts.front')

@section('title', 'Verifikasi Email')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-envelope-check" style="font-size: 48px; color: #6366f1;"></i>
                    </div>
                    <h3 class="h4 mb-1">Verifikasi Email</h3>
                    <p class="text-muted small mb-0">
                        Masukkan kode OTP yang telah dikirim ke email Anda
                    </p>
                    <p class="text-muted small">
                        <strong>{{ Auth::user()->email }}</strong>
                    </p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success py-2">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning py-2">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('warning') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.verify') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Kode Verifikasi (6 digit)</label>
                        <input
                            type="text"
                            name="code"
                            class="form-control text-center"
                            style="font-size: 24px; letter-spacing: 8px; font-family: 'Courier New', monospace;"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            required
                            autofocus
                            placeholder="000000"
                            autocomplete="off"
                        >
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Kode berlaku selama 15 menit
                        </small>
                    </div>

                    <button class="btn btn-primary w-100 mb-3">
                        <i class="bi bi-check-circle me-2"></i>Verifikasi Email
                    </button>
                </form>

                <div class="text-center mb-3">
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none p-0">
                            <i class="bi bi-arrow-clockwise me-1"></i>Kirim Ulang Kode
                        </button>
                    </form>
                </div>

                <hr class="my-3">

                <div class="alert alert-info py-2" style="font-size: 0.85rem;">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Tips:</strong> Periksa folder spam/junk jika email tidak masuk dalam beberapa menit.
                </div>

                <div class="text-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none p-0 text-muted" style="font-size: 0.9rem;">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeInput = document.querySelector('input[name="code"]');
        
        // Hanya angka yang bisa diinput
        codeInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Auto submit jika sudah 6 digit
        codeInput.addEventListener('input', function(e) {
            if (this.value.length === 6) {
                // Optional: auto submit setelah 6 digit
                // this.form.submit();
            }
        });
    });
</script>
@endsection

