<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        {{-- Brand Logo --}}
        <div class="d-flex align-items-center gap-2">
            <span class="brand-badge">Handmade</span>
            <a class="navbar-brand" href="{{ route('home') }}">
                Fay Collection
            </a>
        </div>

        {{-- Mobile Toggle Button --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar Menu --}}
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
                {{-- Home Link --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house me-1"></i>Beranda
                    </a>
                </li>

                {{-- Products Link --}}
                <li class="nav-item">
                    <a class="btn btn-outline-dark btn-sm ms-lg-2" href="{{ route('home') }}#product-list">
                        <i class="bi bi-grid me-1"></i>Lihat Produk
                    </a>
                </li>

                {{-- Auth Section --}}
                @auth
                    {{-- User Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-1"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            @if(auth()->user()->role === 'customer')
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="bi bi-box-seam me-2"></i> Pesanan Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    {{-- Login Link --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1" href="{{ route('login') }}">
                            <i class="bi bi-person"></i>
                            <span>Login</span>
                        </a>
                    </li>
                    {{-- Register Button --}}
                    <li class="nav-item">
                        <a class="btn btn-outline-dark btn-sm ms-lg-2" href="{{ route('register') }}">
                            Daftar
                        </a>
                    </li>
                @endauth

                {{-- Cart Icon --}}
                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" 
                       class="nav-link position-relative {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        <i class="bi bi-cart3" style="font-size: 1.2rem;"></i>
                        @php
                            $cart = session()->get('cart', []);
                            $cartCount = 0;
                            foreach ($cart as $item) {
                                $cartCount += $item['quantity'];
                            }
                        @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                  style="font-size: 0.65rem;">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

