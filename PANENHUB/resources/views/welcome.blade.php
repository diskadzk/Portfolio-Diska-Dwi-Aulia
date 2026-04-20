<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PanenHub | Berdayakan Petani Lokal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-green: #2e7d32;
            --accent-gold: #ffd700;
            --soft-bg: #f4fdf6;
            --shopee-red: #ff4747;
            --dark-auth: #1a1a1a;
        }

        body { background-color: #fcfcfc; font-family: 'Segoe UI', sans-serif; }
        .navbar { background-color: #fff !important; border-bottom: 2px solid var(--primary-green); padding: 1rem 0; }
        .navbar-brand { font-size: 1.5rem; color: var(--primary-green) !important; }
        .btn-search { background-color: var(--primary-green); color: white; border: none; }

        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1530507629858-e4977d30e9e0?q=80&w=1500&auto=format&fit=crop');
            background-size: cover; background-position: center; color: white; padding: 100px 0; text-align: center;
        }

        .impact-box {
            background-color: var(--soft-bg); border-left: 5px solid var(--primary-green);
            border-radius: 10px; padding: 30px; margin-top: -50px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative; z-index: 10;
        }

        .card-product { border: 1px solid #eee; border-radius: 12px; transition: 0.3s; background: #fff; height: 100%; overflow: hidden; }
        .card-product:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
        .img-container { height: 200px; background: #f9f9f9; display: flex; align-items: center; justify-content: center; }
        .img-container img { max-height: 80%; object-fit: contain; }
        .price { color: var(--primary-green); font-weight: bold; font-size: 1.2rem; }
        .btn-beli { background-color: var(--primary-green); color: white; border-radius: 8px; border: none; font-weight: bold; }

        .auth-form-container { padding: 40px; }
        .auth-side-img { background: var(--soft-bg); border-radius: 0 15px 15px 0; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px; }
        .form-control-custom { border-radius: 10px; padding: 12px; border: 1px solid #ddd; margin-bottom: 15px; }
        .btn-auth-submit { background-color: var(--dark-auth); color: white; border-radius: 10px; padding: 12px; font-weight: bold; width: 100%; border: none; }
        
        .cart-item-img { width: 70px; height: 70px; object-fit: cover; border-radius: 8px; }
        .btn-qty { border: 1px solid #ddd; background: #fff; width: 30px; height: 30px; font-weight: bold; }
        .btn-checkout { background-color: var(--shopee-red); color: white; border: none; padding: 12px 50px; font-weight: bold; border-radius: 4px; }

        footer { background-color: #1b5e20; color: white; padding: 40px 0; margin-top: 60px; }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
            <img src="{{ asset('images/logo-icon.png') }}" alt="Logo" style="height: 30px; width: auto; margin-right: 8px;">
            PanenHub
        </a>
        
        <div class="search-container d-none d-md-block flex-grow-1 mx-5">
            <div class="input-group border rounded-pill overflow-hidden">
                <input type="text" id="productSearch" class="form-control border-0 ps-4" placeholder="Cari beras premium...">
                <button class="btn btn-search px-4" onclick="handleSearch()"><i class="bi bi-search"></i></button>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button class="btn position-relative" onclick="showCart()">
                <i class="bi bi-cart3 fs-4"></i>
                <span id="cartBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">0</span>
            </button>
            <div id="authButtons"></div>
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="container">
        <h1 class="display-4 fw-bold">Lebih Dari Sekadar Beras</h1>
        <p class="lead">Mendukung Petani Lokal Mengolah Padi Menjadi Beras Berkualitas Tinggi.</p>
    </div>
</section>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 impact-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="fw-bold text-success">Misi Kami: Kedaulatan Petani</h4>
                    <p class="mb-0 text-muted">Meningkatkan pendapatan petani lokal hingga 30%.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-3 bg-white border rounded shadow-sm">
                        <span class="d-block h2 fw-bold text-success mb-0">50+</span>
                        <span class="small text-uppercase">Mitra Petani</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 pt-4">
    <h3 class="fw-bold mb-4">Hasil Bumi Pilihan</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col product-item">
            <div class="card card-product">
                <div class="img-container">
                    <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?q=80&w=300" alt="Beras Merah">
                </div>
                <div class="product-info p-3">
                    <h6 class="fw-bold product-name">Beras Merah Organik</h6>
                    <p class="small text-muted">2kg - Vakum</p>
                    <div class="price mb-3">Rp 45.000</div>
                    <button class="btn btn-beli w-100 p-2" onclick="addToCart('Beras Merah Organik', 45000, 'https://images.unsplash.com/photo-1586201375761-83865001e31c?q=80&w=300')">Tambah ke Keranjang</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-6 auth-form-container">
                        <button type="button" class="btn-close mb-3" data-bs-dismiss="modal"></button>
                        <h2 class="fw-bold mb-1">Welcome back!</h2>
                        <form id="loginForm">
                            <input type="text" class="form-control form-control-custom" placeholder="Username" id="l_user" required>
                            <input type="password" class="form-control form-control-custom" placeholder="Password" id="l_pass" required>
                            <button type="submit" class="btn btn-auth-submit mt-2">Login</button>
                        </form>
                        <div class="text-center mt-4 small">Not a member? <a href="javascript:void(0)" onclick="openRegister()" class="text-success fw-bold text-decoration-none">Register now</a></div>
                    </div>
                    <div class="col-md-6 d-none d-md-flex auth-side-img">
                        <img src="https://cdni.iconscout.com/illustration/premium/thumb/female-meditation-illustration-4712079.png" class="img-fluid" style="max-width: 220px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-6 auth-form-container">
                        <button type="button" class="btn-close mb-3" data-bs-dismiss="modal"></button>
                        <h2 class="fw-bold mb-1">Create Account</h2>
                        <form id="regForm">
                            <input type="text" class="form-control form-control-custom" placeholder="Nama Lengkap" id="r_name" required>
                            <input type="text" class="form-control form-control-custom" placeholder="Username" id="r_user" required>
                            <input type="password" class="form-control form-control-custom" placeholder="Password" id="r_pass" required>
                            <button type="submit" class="btn btn-auth-submit mt-2">Daftar Sekarang</button>
                        </form>
                    </div>
                    <div class="col-md-6 d-none d-md-flex auth-side-img bg-success-subtle">
                         <i class="bi bi-person-plus-fill display-1 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-success d-flex align-items-center">
                    <img src="{{ asset('images/logo-icon.png') }}" alt="Logo" style="height: 25px; width: auto; margin-right: 8px;">
                    Keranjang Belanja
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <tbody id="cartItemsContainer"></tbody>
                    </table>
                </div>
                <div class="p-4 border-top d-flex justify-content-between align-items-center">
                    <h3 class="fw-bold text-success mb-0" id="totalPriceDisplay">Rp 0</h3>
                    <button class="btn btn-checkout" onclick="alert('Checkout Berhasil!')">Checkout Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container text-center d-flex flex-column align-items-center">
        <img src="{{ asset('images/logo-icon.png') }}" alt="Logo" style="height: 40px; width: auto; margin-bottom: 10px;">
        <h5 class="fw-bold">PanenHub</h5>
        <p class="small">© 2026 PanenHub Project.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // --- JS LOGIC ---
    const SESSION_KEY = "active_user";
    let cart = [];
    let currentUser = JSON.parse(sessionStorage.getItem(SESSION_KEY));

    document.addEventListener("DOMContentLoaded", () => {
        renderNavbar();
        updateCartBadge();
        
        document.getElementById('regForm').addEventListener('submit', registerUser);
        document.getElementById('loginForm').addEventListener('submit', loginUser);
    });

    function openLogin() {
        bootstrap.Modal.getOrCreateInstance(document.getElementById('registerModal')).hide();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('loginModal')).show();
    }

    function openRegister() {
        bootstrap.Modal.getOrCreateInstance(document.getElementById('loginModal')).hide();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('registerModal')).show();
    }

    function renderNavbar() {
        const el = document.getElementById('authButtons');
        if (currentUser) {
            el.innerHTML = `<button class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold" onclick="logout()">Logout (${currentUser.name})</button>`;
        } else {
            el.innerHTML = `<button class="btn btn-success btn-sm rounded-pill px-4 fw-bold" onclick="openLogin()">Masuk</button>`;
        }
    }

    async function registerUser(e) {
        e.preventDefault();
        const data = {
            name: document.getElementById('r_name').value,
            user: document.getElementById('r_user').value,
            pass: document.getElementById('r_pass').value
        };
        const res = await fetch('/api/register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(data)
        });
        if (res.ok) { alert("Berhasil!"); openLogin(); }
    }

    async function loginUser(e) {
        e.preventDefault();
        const data = {
            user: document.getElementById('l_user').value,
            pass: document.getElementById('l_pass').value
        };
        const res = await fetch('/api/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(data)
        });
        const result = await res.json();
        if (res.ok) {
            sessionStorage.setItem(SESSION_KEY, JSON.stringify(result.user));
            location.reload();
        } else { alert("Gagal!"); }
    }

    function logout() { sessionStorage.clear(); location.reload(); }

    function addToCart(name, price, img) {
        if (!currentUser) return openLogin();
        cart.push({ name, price, img, qty: 1 });
        updateCartBadge();
        alert("Ditambahkan!");
    }

    function updateCartBadge() {
        const badge = document.getElementById('cartBadge');
        badge.innerText = cart.length;
        badge.style.display = cart.length > 0 ? 'block' : 'none';
    }

    function showCart() {
        const container = document.getElementById('cartItemsContainer');
        container.innerHTML = cart.map(item => `<tr><td class="ps-4">${item.name}</td><td>Rp ${item.price.toLocaleString()}</td></tr>`).join('');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('cartModal')).show();
    }

    function handleSearch() {
        const q = document.getElementById('productSearch').value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(p => {
            const name = p.querySelector('.product-name').innerText.toLowerCase();
            p.style.display = name.includes(q) ? 'block' : 'none';
        });
    }
</script>
</body>
</html>