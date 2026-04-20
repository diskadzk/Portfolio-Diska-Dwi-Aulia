<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PanenHub | Berdayakan Petani Lokal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-green: #2e7d32;
            --soft-bg: #f4fdf6;
        }

        body { background-color: #ffffff; font-family: 'Segoe UI', sans-serif; color: #333; margin: 0; padding: 0; overflow-x: hidden; }

        .navbar { background: #fff !important; border-bottom: 2px solid var(--primary-green); padding: 15px 0; }
        .navbar-brand { font-size: 1.5rem; color: var(--primary-green) !important; font-weight: bold; }
        .search-container { flex: 1; margin: 0 40px; }
        .search-input { border-radius: 50px 0 0 50px; border: 1px solid #ddd; padding-left: 20px; width: 100%; }
        .search-btn { border-radius: 0 50px 50px 0; background: var(--primary-green); color: white; border: none; padding: 0 25px; }

        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1530507629858-e4977d30e9e0?q=80&w=1500');
            background-size: cover; background-position: center; color: white; padding: 100px 0; text-align: center;
        }
        .btn-yellow { background: #ffc107; color: #000; font-weight: bold; border-radius: 50px; padding: 10px 35px; text-decoration: none; display: inline-block; margin-top: 15px; }
        
        .impact-box {
            background: #f9fffb; border-left: 4px solid var(--primary-green);
            border-radius: 12px; padding: 25px 40px; margin-top: -50px; box-shadow: 0 8px 25px rgba(0,0,0,0.05);
            position: relative; z-index: 10;
        }

        .card-product { border: 1px solid #f0f0f0; border-radius: 15px; overflow: hidden; background: #fff; height: 100%; transition: 0.3s; }
        .img-container { height: 180px; background: #f8f8f8; display: flex; align-items: center; justify-content: center; }
        .img-container img { width: 100%; height: 100%; object-fit: cover; }
        
        .badge-info { font-size: 0.7rem; background: #f0fdf4; color: #166534; padding: 4px 10px; border-radius: 50px; display: inline-block; margin-bottom: 8px; }
        .product-title { font-weight: bold; font-size: 1rem; margin-bottom: 2px; }
        .product-desc { font-size: 0.8rem; color: #777; margin-bottom: 10px; }
        .product-price { font-weight: bold; font-size: 1.1rem; color: var(--primary-green); margin-bottom: 15px; }
        
        .btn-add-cart { 
            background: var(--primary-green); color: white; border: none; width: 100%; 
            padding: 10px; border-radius: 8px; font-weight: 600; font-size: 0.9rem;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        .card-mitra { 
            border: 2px dashed #2e7d32; background: #ffffff; border-radius: 15px; 
            height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px;
            cursor: pointer; transition: 0.3s;
        }
        .card-mitra:hover { background: #f0fdf4; }
        .btn-mitra { border: 1px solid var(--primary-green); color: var(--primary-green); border-radius: 50px; padding: 5px 15px; font-size: 0.8rem; background: transparent; }

        .modal-content { border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 20px 50px rgba(0,0,0,0.15); }
        .auth-left { padding: 40px 45px; }
        .auth-right { background: #f0fdf4; padding: 40px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; border-left: 1px solid #edf2ef; }
        .form-control-custom { border-radius: 8px; padding: 12px 18px; margin-bottom: 12px; border: 1px solid #e2e8e5; background: #f8faf9; width: 100%; transition: 0.2s; }
        .form-control-custom:focus { background: #fff; border-color: var(--primary-green); outline: none; box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1); }
        .btn-login-submit { background: var(--primary-green); color: white; width: 100%; padding: 12px; border-radius: 8px; font-weight: bold; border: none; margin-top: 10px; transition: 0.3s; box-shadow: 0 4px 10px rgba(46, 125, 50, 0.2); }
        .btn-login-submit:hover { background: #1b5e20; transform: translateY(-1px); box-shadow: 0 6px 15px rgba(46, 125, 50, 0.3); }

        .login-logo-right {
            max-width: 400px;
            height: auto;
            margin-bottom: -15px;
        }

        .social-divider { text-align: center; margin: 20px 0; position: relative; color: #888; font-size: 0.8rem; }
        .social-divider::before, .social-divider::after { content: ""; position: absolute; top: 50%; width: 30%; height: 1px; background: #eee; }
        .social-divider::before { left: 0; } .social-divider::after { right: 0; }
        .social-group { display: flex; justify-content: center; gap: 15px; }
        .btn-social { 
            width: 42px; height: 42px; border: 1px solid #eee; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; 
            background: #fff; color: #333; text-decoration: none; transition: 0.3s;
        }
        .btn-social:hover { background: #f8f9fa; transform: translateY(-2px); }

        .mitra-card-refined {
            background: #ffffff;
            border-radius: 12px; 
            overflow: hidden; 
            display: flex; 
            min-height: 550px; 
            width: 100%;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            border: 1px solid #eee;
        }
        .refined-side-left {
            background: #f0fdf4;
            width: 35%; 
            padding: 60px 40px;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            border-right: 1px solid #edf2ef;
            text-align: center;
        }
        .refined-side-left h1 { 
            font-weight: 900; font-size: 2.8rem; color: var(--primary-green); text-transform: uppercase; line-height: 0.9; margin: 0; letter-spacing: -1px;
        }
        .refined-side-right { 
            width: 65%; padding: 50px 60px; position: relative; display: flex; flex-direction: column; justify-content: center; background: #fff;
        }
        .refined-auth-nav { 
            display: flex; justify-content: flex-end; gap: 25px; position: absolute; top: 30px; right: 60px;
        }
        .refined-nav-item { font-size: 0.95rem; color: #888; text-decoration: none; font-weight: 600; cursor: pointer; border: none; background: none; transition: 0.2s; }
        .refined-nav-item.active { 
            color: var(--primary-green); font-weight: 800; border-bottom: 3px solid var(--primary-green); padding-bottom: 3px;
        }
        .refined-input {
            background: #f8faf9; border: 1px solid #e2e8e5;
            border-radius: 8px; padding: 12px 20px; margin-bottom: 15px; width: 100%; font-size: 0.95rem; transition: 0.3s;
        }
        .refined-input:focus {
            background: #fff; border-color: var(--primary-green); outline: none; box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
        }
        .btn-refined-submit {
            background-color: var(--primary-green); color: white; border: none; border-radius: 8px;
            padding: 12px 40px; font-weight: 700; font-size: 1rem;
            align-self: flex-end; margin-top: 15px; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2); transition: 0.3s;
        }
        .btn-refined-submit:hover {
            background-color: #1b5e20; transform: translateY(-1px); box-shadow: 0 6px 15px rgba(46, 125, 50, 0.3);
        }

        footer { 
            background: #1b5e20; 
            color: #fff; 
            padding: 30px 0; 
            margin-top: 100px; 
            text-align: center; 
            width: 100vw; 
            position: relative; 
            left: 50%; 
            right: 50%; 
            margin-left: -50vw; 
            margin-right: -50vw; 
        }

        /* ===== KERANJANG BELANJA MODAL ===== */
        #cartModal .modal-content { border-radius: 4px; border: none; background: #f5f5f5; }
        #cartModal .modal-header { background: #fff; border-bottom: none; padding: 15px 25px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); z-index: 10; }
        #cartModal .modal-header .modal-title { font-weight: 500; font-size: 1.25rem; color: var(--primary-green); }
        #cartModal .modal-body { padding: 15px 20px; }

        .shopee-cart-header { display: flex; align-items: center; background: #fff; padding: 15px 20px; border-radius: 4px; margin-bottom: 12px; font-size: 0.9rem; color: #888; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .col-checkbox { width: 5%; display: flex; align-items: center; justify-content: center; }
        .col-checkbox input { width: 18px; height: 18px; accent-color: var(--primary-green); }
        .col-product { width: 42%; }
        .col-price { width: 16%; text-align: center; }
        .col-qty { width: 16%; display: flex; justify-content: center; align-items: center; }
        .col-total { width: 16%; text-align: center; font-weight: bold; }
        .col-action { width: 5%; text-align: center; }

        .shopee-store-card { background: #fff; border-radius: 4px; margin-bottom: 15px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); overflow: hidden; }
        .shopee-store-header { padding: 15px 20px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; }
        .shopee-store-header input { width: 18px; height: 18px; accent-color: var(--primary-green); }
        
        .shopee-item-row { display: flex; align-items: center; padding: 20px; border-bottom: 1px dashed #eee; }
        .shopee-item-row:last-child { border-bottom: none; }
        .shopee-item-img { width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 2px; }
        .shopee-total-price { color: var(--primary-green); font-weight: bold; }

        .shopee-voucher-card { background: #fff; border-bottom: 1px solid #f0f0f0; padding: 15px 20px; font-size: 0.9rem; border-top: 1px solid #f0f0f0; border-radius: 4px 4px 0 0; margin-top: 20px;}
        .shopee-shipping-card { background: #fdfdfd; padding: 15px 20px; font-size: 0.9rem; border-bottom: 1px solid #f0f0f0; border-radius: 0 0 4px 4px; margin-bottom: 15px;}
        
        .shopee-platform-voucher { background: #fff; padding: 20px; font-size: 0.95rem; border-radius: 4px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); margin-bottom: 15px;}

        .shopee-sticky-footer { background: #fff; padding: 15px 25px; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 -4px 10px rgba(0,0,0,0.05); position: sticky; bottom: 0; z-index: 100; border-top: 1px dashed #eee; font-size: 1rem; margin-top: 15px;}
        .shopee-grand-total { font-size: 1.5rem; font-weight: bold; color: var(--primary-green); }
        .shopee-checkout-btn { background: var(--primary-green); color: #fff; border: none; padding: 12px 40px; font-size: 1.1rem; border-radius: 2px; height: 100%; transition: 0.2s;}
        .shopee-checkout-btn:hover { background: #1b5e20; }
        .cursor-pointer { cursor: pointer; }

        .cart-qty-control { display: inline-flex; border: 1px solid #ddd; border-radius: 2px; overflow: hidden; background: #fff; height: 32px; }
        .cart-qty-btn { width: 32px; height: 100%; border: none; background: transparent; color: #555; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1rem; }
        .cart-qty-btn:hover { background: #f5f5f5; }
        .cart-qty-val { width: 45px; height: 100%; text-align: center; border: none; border-left: 1px solid #ddd; border-right: 1px solid #ddd; background: transparent; font-size: 0.9rem; }
        
        .cart-empty { padding: 50px 28px; text-align: center; color: #aaa; background: #fff; border-radius: 4px; }
        .cart-empty i { font-size: 3rem; margin-bottom: 10px; display: block; }

        .fab-mitra {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, var(--primary-green) 0%, #1b5e20 100%);
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(46, 125, 50, 0.4);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            text-decoration: none;
            border: 2px solid rgba(255,255,255,0.2);
        }
        .fab-mitra:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 30px rgba(46, 125, 50, 0.6);
            color: white;
        }
        .fab-mitra i { font-size: 1.4rem; }
        .fab-mitra .fab-badge {
            background: #ffc107;
            color: #000;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 10px;
            position: absolute;
            top: -10px;
            right: 15px;
            font-weight: 900;
            text-transform: uppercase;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        /* Animations & Skeleton */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeInUp 0.6s ease-out forwards; }
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #f8f8f8 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
        }
        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body>

<nav class="navbar sticky-top shadow-sm px-2 px-md-0">
    <div class="container d-flex align-items-center">
        <a class="navbar-brand d-flex align-items-center flex-shrink-0" href="#">
            <img src="{{ asset('images/logo-icon.png') }}" alt="Logo" style="height: 35px; width: auto; margin-right: 10px;">
            PanenHub
        </a>
        
        <div class="search-container d-none d-md-flex">
            <input type="text" id="searchInput" class="form-control search-input" placeholder="Cari beras premium hasil petani lokal..." onkeyup="filterProducts()">
            <button class="search-btn" onclick="filterProducts()"><i class="bi bi-search"></i></button>
        </div>
        
        <div class="d-flex align-items-center gap-3 flex-shrink-0 ms-auto">
            <a href="javascript:void(0)" class="text-dark position-relative me-2" onclick="openCart()">
                <i class="bi bi-cart3 fs-4"></i>
                <span id="cartCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none">0</span>
            </a>
            @auth
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold d-none d-lg-inline">Hai, {{ Auth::user()->name }}</span>
                    <a href="{{ route('buyer.orders') }}" class="text-dark text-decoration-none fw-bold small d-none d-sm-inline"><i class="bi bi-bag-check me-1"></i> Pesanan</a>
                    @if(Auth::user()->role === 'mitra')
                        <a href="{{ route('mitra.products') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">Mitra</a>
                    @endif
                    <form action="/api/logout" method="POST" class="m-0" onsubmit="localStorage.removeItem('panenhub_cart')">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold">Logout</button>
                    </form>
                </div>
            @else
                <button class="btn btn-success rounded-pill px-4 fw-bold" onclick="openLogin()">Masuk</button>
            @endauth
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="container">
        <h1 class="display-4 fw-bold">Lebih Dari Sekadar Beras</h1>
        <p class="fs-5">Mendukung Petani Lokal Mengolah Padi Menjadi Beras Berkualitas Tinggi.</p>
        <a href="#produk" class="btn-yellow">Belanja Sekarang</a>
    </div>
</section>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="impact-box d-md-flex align-items-center justify-content-between">
                <div class="pe-md-4">
                    <h5 class="fw-bold text-success mb-2 fs-4">Misi Kami: Kedaulatan Petani</h5>
                    <p class="text-muted small mb-0 fs-6">Kami memberdayakan petani lokal untuk meningkatkan nilai hasil panen melalui proses pengolahan mandiri menjadi beras berkualitas tinggi. Dengan pendekatan ini, petani tidak hanya menjual bahan mentah, tetapi juga memperoleh nilai tambah yang berdampak langsung pada peningkatan kesejahteraan keluarga mereka.</p>
                </div>
                    <div class="text-center mt-3 mt-md-0 ps-md-4">
                    <div class="bg-white shadow-sm border rounded-4 p-3" style="min-width: 150px;">
                        <h2 class="fw-bold text-success mb-0">50+</h2>
                        <p class="small text-muted text-uppercase fw-bold mb-0" style="font-size: 0.7rem; letter-spacing: 1px;">Mitra Petani</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 pt-4 px-4 px-md-0" id="produk">
    <h3 class="fw-bold mb-4 text-center">Hasil Bumi Pilihan</h3>
    <div class="row g-4 justify-content-center">
        @foreach($products as $product)
            <div class="col-md-3 product-card-col fade-in">
                <div class="card card-product">
                    <div class="img-container">
                        @php
                            $imagePath = 'storage/' . $product->image;
                            if (!file_exists(public_path($imagePath)) || empty($product->image)) {
                                if (str_contains(strtolower($product->name), 'merah')) {
                                    $imagePath = 'images/Beras-Merah.jpeg';
                                } elseif (str_contains(strtolower($product->name), 'pandan') || str_contains(strtolower($product->name), 'wangi')) {
                                    $imagePath = 'images/Beras-Organik.jpeg';
                                } elseif (str_contains(strtolower($product->name), 'ketan')) {
                                    $imagePath = 'images/Beras-Ketan-Putih.jpeg';
                                } else {
                                    $imagePath = 'images/Beras-Merah.jpeg';
                                }
                            }
                        @endphp
                        <img src="{{ asset($imagePath) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="p-3">
                        <div class="badge-info">{{ $product->user->name ?? 'Mitra PanenHub' }}</div>
                        <div class="product-title">{{ $product->name }}</div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="product-price mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <span class="badge {{ $product->stock > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border-0">Stok: {{ $product->stock }}</span>
                        </div>
                        @if($product->stock > 0)
                            <button class="btn-add-cart" onclick="addToCart('product-{{ $product->id }}','{{ addslashes($product->name) }}', {{ (int)$product->price }}, '{{ asset($imagePath) }}', '{{ addslashes($product->user->name ?? 'Mitra PanenHub') }}')"><i class="bi bi-cart-plus"></i> Tambah</button>
                        @else
                            <button class="btn-add-cart" style="background:#e0e0e0; color:#888; cursor:not-allowed;" disabled><i class="bi bi-x-circle"></i> Produk Habis</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        
        <!-- Tombol FAB Mitra -->
    </div>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="row g-0">
                <div class="col-md-6 auth-left">
                    <button type="button" class="btn-close mb-3" data-bs-dismiss="modal"></button>
                    <h2 class="fw-bold mb-1">Welcome!</h2>
                    <p class="text-muted small mb-4">Masuk untuk mulai mengisi keranjang belanja Anda dengan hasil tani terbaik.</p>
                    <form action="/api/login" method="POST">
                        @csrf
                        <label class="small fw-bold text-muted mb-1">Email</label>
                        <input type="email" name="email" class="form-control form-control-custom" placeholder="email@contoh.com" required>
                        <label class="small fw-bold text-muted mb-1">Password</label>
                        <input type="password" name="password" class="form-control form-control-custom" placeholder="••••••••" required>
                        <button type="submit" class="btn-login-submit">Login</button>
                    </form>
                    <div class="social-divider">or continue with</div>
                    <div class="social-group">
                        <a href="javascript:void(0)" class="btn-social" onclick="socialLogin('Google')"><i class="bi bi-google text-danger"></i></a>
                        <a href="javascript:void(0)" class="btn-social" onclick="socialLogin('Apple')"><i class="bi bi-apple"></i></a>
                        <a href="javascript:void(0)" class="btn-social" onclick="socialLogin('Facebook')"><i class="bi bi-facebook text-primary"></i></a>
                    </div>
                    <div class="text-center mt-4 small">
                        Not a member? <a href="javascript:void(0)" onclick="bootstrap.Modal.getInstance(document.getElementById('loginModal')).hide(); setTimeout(openRegister, 400);" class="text-success fw-bold text-decoration-none">Register now</a>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-flex auth-right">
                    <img src="images/logo-icon.png" alt="Logo PanenHub" class="login-logo-right">
                    <p class="small text-muted px-4 text-center">Nikmati kemudahan belanja beras langsung dari penggilingan petani lokal.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="row g-0">
                <div class="col-md-6 auth-left">
                    <button type="button" class="btn-close mb-3" data-bs-dismiss="modal"></button>
                    <h2 class="fw-bold mb-1">Join PanenHub</h2>
                    <p class="text-muted small mb-4">Buat akun pembeli untuk belanja beras hasil tani lokal.</p>
                    <form action="/api/register" method="POST">
                        @csrf
                        <label class="small fw-bold text-muted mb-1">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control-custom" placeholder="Masukkan nama" required>
                        <label class="small fw-bold text-muted mb-1">Email</label>
                        <input type="email" name="email" class="form-control form-control-custom" placeholder="email@contoh.com" required>
                        <label class="small fw-bold text-muted mb-1">Password</label>
                        <input type="password" name="password" class="form-control form-control-custom" placeholder="Buat password" required>
                        <button type="submit" class="btn-login-submit" style="background: var(--primary-green);">Daftar Akun</button>
                    </form>
                    <div class="text-center mt-4 small">
                        Already have an account? <a href="javascript:void(0)" onclick="bootstrap.Modal.getInstance(document.getElementById('registerModal')).hide(); setTimeout(openLogin, 400);" class="text-success fw-bold text-decoration-none">Login here</a>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-flex auth-right" style="background: #f0fdf4 !important;">
                    <img src="images/logo-icon.png" alt="Logo PanenHub" class="login-logo-right">
                    <h5 class="fw-bold text-success mb-2">Healthy Life, Happy Farmer</h5>
                    <p class="small text-muted px-4 text-center">Dapatkan beras segar langsung dari sumbernya dan bantu sejahterakan petani kita.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mitraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered"> 
        <div class="modal-content border-0 bg-transparent">
                <div class="mitra-card-refined">
                    <button type="button" class="btn-close m-4 position-absolute top-0 end-0" data-bs-dismiss="modal" style="z-index: 10;"></button>

                    <div class="refined-side-left">
                        <div class="mb-4">
                            <i class="bi bi-stars text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h1>MITRA</h1>
                        <h1>TANI</h1>
                        <p class="mt-4 text-success fw-bold">PANENHUB PROJECT</p>
                    </div>

                    <div class="refined-side-right">
                        <div class="refined-auth-nav">
                            <button id="tabGabung" class="refined-nav-item active" onclick="switchMitraTab('gabung')">Gabung</button>
                            <button id="tabMasuk" class="refined-nav-item" onclick="switchMitraTab('masuk')">Masuk</button>
                        </div>

                        <div id="formGabung">
                            <form action="/api/register-mitra" method="POST">
                                @csrf
                                <div class="mb-1">
                                    <label class="small fw-bold ms-1 mb-2 text-muted uppercase" style="letter-spacing: 0.5px;">IDENTITAS TERDAFTAR</label>
                                    <input type="text" name="name" class="refined-input" placeholder="Nama Lengkap / Kelompok Tani" required>
                                </div>
                                <div class="mb-1">
                                    <input type="text" name="location" class="refined-input" placeholder="Lokasi Lahan (Kecamatan/Kota)" required>
                                </div>
                                <div class="mb-1">
                                    <input type="tel" name="phone" class="refined-input" placeholder="Nomor WhatsApp Aktif" required>
                                </div>
                                <div class="mb-1">
                                    <input type="text" class="refined-input" placeholder="Komoditas Utama (Beras Putih/Merah/Ketan)" required>
                                </div>
                                <div class="mb-1">
                                    <input type="email" name="email" class="refined-input" placeholder="Email untuk Login" required>
                                </div>
                                <div class="mb-1">
                                    <input type="password" name="password" class="refined-input" placeholder="Buat Password" required>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="#" class="text-muted small text-decoration-none"><i class="bi bi-question-circle me-1"></i> Butuh bantuan daftar?</a>
                                    <button type="submit" class="btn-refined-submit">DAFTAR SEKARANG</button>
                                </div>
                            </form>
                        </div>

                        <div id="formMasuk" style="display: none;">
                            <form action="/api/login" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="small fw-bold ms-1 mb-3 text-muted uppercase" style="letter-spacing: 0.5px;">LOGIN MITRA TANI</label>
                                    <input type="email" name="email" class="refined-input" placeholder="Email / ID Mitra" required>
                                </div>
                                <div class="mb-2">
                                    <input type="password" name="password" class="refined-input" placeholder="Password" required>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="#" class="text-muted small text-decoration-none">Lupa password mitra?</a>
                                    <button type="submit" class="btn-refined-submit">MASUK </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<!-- ===== KERANJANG BELANJA MODAL ===== -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg bg-light" style="max-height: 90vh;">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center">
                    <img src="{{ asset('images/logo-icon.png') }}" alt="Logo" style="height: 25px; width: auto; margin-right: 8px;">
                    Keranjang Belanja
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body position-relative">
                <div id="cartContent">
                    <!-- Dirender melalui JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAB Mitra -->
<div class="fab-mitra" onclick="openMitraModal()">
    <div class="fab-badge">Baru</div>
    <i class="bi bi-shop"></i>
    <span>Daftarkan Hasil Panen</span>
</div>

<!-- ===== CHECKOUT PAYMENT MODAL ===== -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success"><i class="bi bi-wallet2 me-2"></i> Pembayaran Aman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="/api/checkout" method="POST" id="checkoutForm" onsubmit="return submitCheckout()">
                    @csrf
                    <input type="hidden" name="cart" id="checkoutCartData">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Total Pembayaran</label>
                        <h3 class="fw-bold text-success" id="paymentTotalDisplay">Rp 0</h3>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Metode Pembayaran</label>
                        <select name="payment_method" id="paymentMethodSelect" class="form-select bg-light border-0 py-2" required onchange="toggleBankInstructions(this.value)">
                            <option value="">-- Pilih Metode --</option>
                            <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                            <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                            <option value="QRIS">QRIS PanenHub</option>
                            <option value="COD (Bayar di Tempat)">COD (Bayar di Tempat)</option>
                        </select>
                    </div>

                    <div id="bankInstructions" class="mb-3 p-3 bg-warning-subtle rounded border border-warning" style="display:none">
                        <div id="bankBCA" class="bank-detail" style="display:none">
                            <p class="mb-1 small fw-bold">No. Rekening BCA:</p>
                            <h5 class="fw-bold mb-0">8010 4422 99 a/n PanenHub</h5>
                        </div>
                        <div id="bankMandiri" class="bank-detail" style="display:none">
                            <p class="mb-1 small fw-bold">No. Rekening Mandiri:</p>
                            <h5 class="fw-bold mb-0">131 000 8899 775 a/n PT Panen Digital</h5>
                        </div>
                        <p class="mt-2 mb-0 x-small text-muted" style="font-size: 0.7rem;">Silahkan transfer sesuai total biaya. Verifikasi dilakukan otomatis setelah pembayaran.</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Alamat Pengiriman</label>
                        <textarea name="address" class="form-control bg-light border-0" rows="3" placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota" required></textarea>
                        <div class="form-text x-small" style="font-size: 0.75rem;">Pastikan alamat lengkap untuk memudahkan pengiriman oleh Kurir PanenHub.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Catatan (Opsional)</label>
                        <input type="text" name="notes" class="form-control bg-light border-0" placeholder="Pagar hitam, dekat masjid, dll.">
                    </div>

                    <div class="alert alert-success bg-success-subtle border-0 small">
                        <i class="bi bi-shield-check me-1"></i> Pembayaran Anda dijamin aman 100% oleh sistem PanenHub. Dana baru akan diteruskan ke Petani setelah pesanan Anda selesai.
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-3 fw-bold rounded-pill shadow-sm" style="font-size: 1.1rem;">Bayar Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container text-center">
        <div class="d-flex flex-column align-items-center mb-1">
            <img src="{{ asset('images/logo-icon.png') }}" alt="Logo" style="height: 50px; width: auto; margin-bottom: 10px;">
            <p class="mb-1 fw-bold fs-5">PanenHub</p>
        </div>
        <p class="small mb-1">Platform Digital untuk Kedaulatan Pangan Indonesia.</p>
        <p class="mb-0 small">© 2026 PanenHub Project. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const isAuthenticated = @auth true @else false @endauth;

    // ===== MODAL HELPERS =====
    function openLogin() { new bootstrap.Modal(document.getElementById('loginModal')).show(); }
    function openRegister() { new bootstrap.Modal(document.getElementById('registerModal')).show(); }
    function openMitraModal() { new bootstrap.Modal(document.getElementById('mitraModal')).show(); }
    function openCart() { renderCart(); new bootstrap.Modal(document.getElementById('cartModal')).show(); }
    function socialLogin(platform) { 
        window.location.href = "/auth/" + platform.toLowerCase() + "/redirect";
    }

    function toggleBankInstructions(val) {
        var box = document.getElementById('bankInstructions');
        var bca = document.getElementById('bankBCA');
        var mandiri = document.getElementById('bankMandiri');
        
        box.style.display = 'none';
        bca.style.display = 'none';
        mandiri.style.display = 'none';

        if (val === 'Transfer Bank BCA') {
            box.style.display = 'block';
            bca.style.display = 'block';
        } else if (val === 'Transfer Bank Mandiri') {
            box.style.display = 'block';
            mandiri.style.display = 'block';
        }
    }

    // ===== PENCARIAN PRODUK (SEARCH) =====
    function filterProducts() {
        var input = document.getElementById('searchInput');
        var filter = input.value.toLowerCase();
        var cols = document.getElementsByClassName('product-card-col');
        
        for (var i = 0; i < cols.length; i++) {
            var title = cols[i].getElementsByClassName('product-title')[0];
            var mitra = cols[i].getElementsByClassName('badge-info')[0];
            var name = title.innerText.toLowerCase();
            var mitraName = mitra ? mitra.innerText.toLowerCase() : "";
            
            if (name.indexOf(filter) > -1 || mitraName.indexOf(filter) > -1) {
                cols[i].style.display = "";
            } else {
                cols[i].style.display = "none";
            }
        }
    }

    // ===== SWITCH TAB MITRA =====
    function switchMitraTab(tab) {
        const formGabung = document.getElementById('formGabung');
        const formMasuk = document.getElementById('formMasuk');
        const tabGabung = document.getElementById('tabGabung');
        const tabMasuk = document.getElementById('tabMasuk');
        if (tab === 'gabung') {
            formGabung.style.display = 'block'; formMasuk.style.display = 'none';
            tabGabung.classList.add('active'); tabMasuk.classList.remove('active');
        } else {
            formGabung.style.display = 'none'; formMasuk.style.display = 'block';
            tabGabung.classList.remove('active'); tabMasuk.classList.add('active');
        }
    }

    // ===== KERANJANG BELANJA (CART) =====
    function getCart() {
        var raw = JSON.parse(localStorage.getItem('panenhub_cart') || '[]');
        var needsSave = false;
        var clean = raw.filter(function(item) {
            return item && item.id && item.name && item.price && item.image && item.mitra;
        }).map(function(item) {
            if (typeof item.selected === 'undefined') {
                item.selected = true;
                needsSave = true;
            }
            return item;
        });
        if (clean.length !== raw.length || needsSave) {
            localStorage.setItem('panenhub_cart', JSON.stringify(clean));
        }
        return clean;
    }

    function saveCart(cart) {
        localStorage.setItem('panenhub_cart', JSON.stringify(cart));
        updateCartBadge();
    }

    function addToCart(id, name, price, image, mitra) {
        if (!isAuthenticated) {
            openLogin();
            return;
        }
        var cart = getCart();
        var idx = -1;
        for (var i = 0; i < cart.length; i++) {
            if (cart[i].id === id) { idx = i; break; }
        }
        if (idx >= 0) {
            cart[idx].qty += 1;
        } else {
            cart.push({ id: id, name: name, price: price, image: image, mitra: mitra, qty: 1 });
        }
        saveCart(cart);

        var toast = document.createElement('div');
        toast.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>' + name + ' ditambahkan ke keranjang!';
        toast.style.cssText = 'position:fixed;bottom:30px;left:50%;transform:translateX(-50%);background:#2e7d32;color:#fff;padding:12px 28px;border-radius:50px;font-weight:600;font-size:0.9rem;z-index:9999;box-shadow:0 6px 20px rgba(0,0,0,0.15);animation:fadeInUp .3s ease;';
        document.body.appendChild(toast);
        setTimeout(function() { toast.remove(); }, 2000);
    }

    function removeFromCart(id) {
        var cart = getCart();
        var newCart = [];
        for (var i = 0; i < cart.length; i++) {
            if (cart[i].id !== id) {
                newCart.push(cart[i]);
            }
        }
        saveCart(newCart);
        renderCart();
    }

    function changeQty(id, delta) {
        var cart = getCart();
        for (var i = 0; i < cart.length; i++) {
            if (cart[i].id === id) {
                cart[i].qty += delta;
                if (cart[i].qty < 1) cart[i].qty = 1;
                break;
            }
        }
        saveCart(cart);
        renderCart();
    }

    function formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    function updateCartBadge() {
        var cart = getCart();
        var badge = document.getElementById('cartCount');
        if (!badge) return;
        var totalItems = 0;
        for (var i = 0; i < cart.length; i++) { totalItems += cart[i].qty; }
        if (totalItems > 0) {
            badge.textContent = totalItems;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }

    function renderCart() {
        var cart = getCart();
        var container = document.getElementById('cartContent');
        if (!container) return;

        if (cart.length === 0) {
            container.innerHTML = '<div class="cart-empty">' +
                '<i class="bi bi-cart-x"></i>' +
                '<h5 class="fw-bold text-muted">Keranjang Kosong</h5>' +
                '<p class="small">Belum ada produk dari sahabat petani kita, yuk mulai belanja!</p>' +
                '</div>';
            return;
        }

        var grandTotal = 0;
        var totalQty = 0;
        var allSelected = true;
        
        var groupedCart = {};
        for (var i = 0; i < cart.length; i++) {
            var item = cart[i];
            if (!item.selected) allSelected = false;
            if (item.selected) {
                var lineTotal = item.price * item.qty;
                grandTotal += lineTotal;
                totalQty += item.qty;
            }
            if (!groupedCart[item.mitra]) groupedCart[item.mitra] = [];
            groupedCart[item.mitra].push(item);
        }

        var html = '<div class="shopee-cart-header">' +
            '<div class="col-checkbox"><input type="checkbox" ' + (allSelected ? 'checked' : '') + ' data-action="toggle-all" class="cursor-pointer" style="width:18px;height:18px;accent-color:var(--primary-green);"></div>' +
            '<div class="col-product">Produk</div>' +
            '<div class="col-price">Harga Satuan</div>' +
            '<div class="col-qty">Kuantitas</div>' +
            '<div class="col-total">Total Harga</div>' +
            '<div class="col-action">Aksi</div>' +
        '</div>';

        for (var mitra in groupedCart) {
            var items = groupedCart[mitra];
            var storeSelected = items.every(function(i) { return i.selected; });

            html += '<div class="shopee-store-card">';
            html += '<div class="shopee-store-header">' +
                        '<input type="checkbox" ' + (storeSelected ? 'checked' : '') + ' data-action="toggle-store" data-mitra="' + mitra + '" class="me-3 cursor-pointer" style="width:18px;height:18px;accent-color:var(--primary-green);">' +
                        '<span class="badge bg-success me-2">Star</span>' +
                        '<span class="fw-bold me-3 text-dark">' + mitra + '</span>' +
                        '<i class="bi bi-chat-dots-fill text-success fs-5 cursor-pointer"></i>' +
                    '</div>';
            
            for (var j = 0; j < items.length; j++) {
                var item = items[j];
                var lineTotal = item.price * item.qty;
                
                html += '<div class="shopee-item-row">' +
                    '<div class="col-checkbox"><input type="checkbox" ' + (item.selected ? 'checked' : '') + ' data-action="toggle-item" data-id="' + item.id + '" class="cursor-pointer" style="width:18px;height:18px;accent-color:var(--primary-green);"></div>' +
                    '<div class="col-product d-flex">' +
                        '<img src="' + (item.image.startsWith('http') || item.image.startsWith('/') ? item.image : '/' + item.image) + '" alt="' + item.name + '" class="shopee-item-img">' +
                        '<div class="ms-3 pt-1">' +
                            '<div class="fw-bold text-dark mb-1" style="font-size:0.95rem;">' + item.name + '</div>' +
                            '<div class="small text-muted mb-2">Bebas Pengembalian 7 Hari</div>' +
                            '<span class="badge border border-success border-opacity-50 text-success rounded-1 bg-success-subtle"><i class="bi bi-lightning-fill text-warning"></i> PanenHub Extra</span>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-price text-muted">' + formatRupiah(item.price) + '</div>' +
                    '<div class="col-qty">' +
                        '<div class="cart-qty-control">' +
                            '<button type="button" class="cart-qty-btn" data-action="minus" data-id="' + item.id + '">&minus;</button>' +
                            '<input type="text" class="cart-qty-val" value="' + item.qty + '" readonly>' +
                            '<button type="button" class="cart-qty-btn" data-action="plus" data-id="' + item.id + '">+</button>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-total shopee-total-price">' + formatRupiah(lineTotal) + '</div>' +
                    '<div class="col-action">' +
                        '<button type="button" class="btn text-muted p-0 shadow-none border-0 cart-delete-btn" data-action="delete" data-id="' + item.id + '"><i class="bi bi-trash3 fs-5"></i></button>' +
                    '</div>' +
                '</div>';
            }
            html += '</div>';
        }

        html += '<div class="shopee-voucher-card">' +
            '<div class="d-flex align-items-center text-success fw-bold cursor-pointer">' +
                '<i class="bi bi-ticket-perforated fs-5 me-2"></i> Tambahkan kode Voucher Toko' +
            '</div>' +
        '</div>';

        html += '<div class="shopee-shipping-card">' +
            '<div class="d-flex align-items-center">' +
                '<i class="bi bi-truck text-success fs-4 me-3"></i>' +
                '<span class="text-dark small">Gratis Ongkir s/d Rp60.000 dengan min. belanja Rp150.000 <a href="javascript:void(0)" class="text-success text-decoration-none ms-1">Pelajari lebih lanjut</a></span>' +
            '</div>' +
        '</div>';

        html += '<div class="shopee-platform-voucher">' +
            '<div class="d-flex align-items-center justify-content-between">' +
                '<div class="d-flex align-items-center fw-bold text-dark"><i class="bi bi-ticket-fill text-success fs-4 me-3"></i> Voucher PanenHub</div>' +
                '<div class="text-success fw-bold cursor-pointer small">Gunakan/masukkan kode</div>' +
            '</div>' +
        '</div>';

        // Sticky Footer Bottom summary
        html += '<div class="shopee-sticky-footer">' +
            '<div class="d-flex align-items-center">' +
                '<input type="checkbox" ' + (allSelected ? 'checked' : '') + ' data-action="toggle-all" class="me-3 cursor-pointer" style="width: 18px; height: 18px; accent-color: var(--primary-green);">' +
                '<span class="me-4 text-dark small fw-bold">Pilih Semua</span>' +
                '<span class="me-4 text-dark cursor-pointer small">Hapus</span>' +
                '<span class="text-success cursor-pointer small fw-bold">Tambahkan ke Favorit Saya</span>' +
            '</div>' +
            '<div class="d-flex align-items-center">' +
                '<div class="me-4 text-end">' +
                    '<span class="text-dark me-2 small">Total (' + totalQty + ' produk):</span>' +
                    '<span class="shopee-grand-total">' + formatRupiah(grandTotal) + '</span>' +
                '</div>' +
                '<button class="shopee-checkout-btn fw-bold shadow-sm" id="btnCheckout">Checkout</button>' +
            '</div>' +
        '</div>';

        container.innerHTML = html;
    }

    function submitCheckout() {
        var cart = getCart().filter(function(i) { return i.selected; });
        if (cart.length === 0) {
            alert("Harap pilih minimal 1 produk untuk melanjutkan checkout!");
            return false;
        }
        document.getElementById('checkoutCartData').value = JSON.stringify(cart);
        return true;
    }

    // Event Delegation
    document.addEventListener('change', function(e) {
        var target = e.target.closest('input[type="checkbox"]');
        if (!target) return;
        var action = target.getAttribute('data-action');
        var cart = getCart();

        if (action === 'toggle-item') {
            var id = target.getAttribute('data-id');
            for (var i = 0; i < cart.length; i++) {
                if (cart[i].id === id) cart[i].selected = target.checked;
            }
            saveCart(cart);
            renderCart();
        } else if (action === 'toggle-store') {
            var mitra = target.getAttribute('data-mitra');
            for (var i = 0; i < cart.length; i++) {
                if (cart[i].mitra === mitra) cart[i].selected = target.checked;
            }
            saveCart(cart);
            renderCart();
        } else if (action === 'toggle-all') {
            for (var i = 0; i < cart.length; i++) {
                cart[i].selected = target.checked;
            }
            saveCart(cart);
            renderCart();
        }
    });

    document.addEventListener('click', function(e) {
        var target = e.target.closest('[data-action]');
        if (!target || target.tagName === 'INPUT') return; // let change handle inputs
        var action = target.getAttribute('data-action');
        var id = target.getAttribute('data-id');
        if (action === 'delete') {
            removeFromCart(id);
        } else if (action === 'minus') {
            changeQty(id, -1);
        } else if (action === 'plus') {
            changeQty(id, 1);
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'btnCheckout') {
            if (!isAuthenticated) {
                openLogin();
                return;
            }
            var selectedCart = getCart().filter(function(i) { return i.selected; });
            if (selectedCart.length === 0) {
                alert("Pilih minimal 1 produk terlebih dahulu!");
                return;
            }
            
            var grandTotal = 0;
            for (var i = 0; i < selectedCart.length; i++) {
                grandTotal += selectedCart[i].price * selectedCart[i].qty;
            }
            document.getElementById('paymentTotalDisplay').textContent = formatRupiah(grandTotal);

            
            var cartModalEl = document.getElementById('cartModal');
            if (cartModalEl) {
                var inst = bootstrap.Modal.getInstance(cartModalEl);
                if (inst) inst.hide();
            }
            
            setTimeout(function() {
                var pmEl = document.getElementById('paymentModal');
                if (pmEl) new bootstrap.Modal(pmEl).show();
            }, 400);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        getCart();
        updateCartBadge();
        
        // Jika flash message success checkout muncul, baru kosongkan keranjang lokal
        @if(session('success') && str_contains(session('success'), 'Checkout berhasil'))
            localStorage.removeItem('panenhub_cart');
            updateCartBadge();
        @endif
    });
</script>
    @if($errors->any())
    <script>
        alert("{{ $errors->first() }}");
    </script>
    @endif
    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
</body>
</html>