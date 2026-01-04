<footer class="py-4 mt-5 border-top">
    <div class="container">
        <div class="row g-3">
            {{-- About Section --}}
            <div class="col-md-4">
                <h6 class="fw-bold mb-2">Fay Collection</h6>
                <p class="text-muted small mb-0">
                    Produk rajut handmade berkualitas tinggi. Dirajut dengan cinta di Indonesia.
                </p>
            </div>

            {{-- Quick Links --}}
            <div class="col-md-4">
                <h6 class="fw-bold mb-2">Tautan Cepat</h6>
                <ul class="list-unstyled small">
                    <li class="mb-1">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                            Beranda
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('home') }}#product-list" class="text-muted text-decoration-none">
                            Produk
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->role === 'customer')
                            <li class="mb-1">
                                <a href="{{ route('orders.index') }}" class="text-muted text-decoration-none">
                                    Pesanan Saya
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>

            {{-- Contact & Admin --}}
            <div class="col-md-4">
                <h6 class="fw-bold mb-2">Kontak</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="https://wa.me/6285172343199" 
                           target="_blank" 
                           class="text-muted text-decoration-none">
                            <i class="bi bi-whatsapp me-1"></i> WhatsApp
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('login') }}" 
                           class="text-muted text-decoration-none">
                            <i class="bi bi-shield-lock me-1"></i> Login Admin/Customer
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="row mt-3 pt-3 border-top">
            <div class="col-12">
                <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                    <span class="small text-muted">
                        © {{ date('Y') }} Fay Collection. All rights reserved.
                    </span>
                    <span class="small text-muted">
                        Made with <i class="bi bi-heart-fill text-danger"></i> in Indonesia
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- Floating WhatsApp Button --}}
<a href="https://wa.me/6285172343199?text=Halo%20Fay%20Collection,%20saya%20ingin%20bertanya%20tentang%20produk."
    class="floating-wa" target="_blank" title="Hubungi via WhatsApp">
    <i class="bi bi-whatsapp"></i>
    <span class="d-none d-md-inline">Butuh bantuan?</span>
</a>

