<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mitra | PanenHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-green: #2e7d32;
            --muted-blue: #1e40af;
        }
        .btn-edit { color: var(--muted-blue); border-color: var(--muted-blue); }
        .btn-edit:hover { background-color: var(--muted-blue); color: white; }
        .text-muted-blue { color: var(--muted-blue) !important; }
        .btn-muted-blue { background-color: var(--muted-blue); color: white; }
        .btn-muted-blue:hover { background-color: #173693; color: white; }
        body { background-color: #f4fdf6; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #fff !important; border-bottom: 2px solid var(--primary-green); padding: 12px 0; }
        .navbar-brand { font-size: 1.5rem; color: var(--primary-green) !important; font-weight: bold; }
        .sidebar { background: #fff; border-right: 1px solid #ddd; height: calc(100vh - 70px); padding: 20px; }
        .main-content { padding: 40px; }
        .stat-card { background: #fff; border-radius: 12px; padding: 20px; border-left: 5px solid var(--primary-green); box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        
        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeInUp 0.6s ease-out forwards; }
    </style>
</head>
<body>

<nav class="navbar sticky-top shadow-sm">
    <div class="container-fluid px-5 d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('images/logo-icon.png') }}" alt="Logo" style="height: 30px; width: auto; margin-right: 8px;">
            PanenHub <span class="fs-6 text-muted ms-2">Mitra Panel</span>
        </a>
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold">Mitra Tani: {{ Auth::user()->name }}</span>
                <button class="btn btn-sm btn-light border rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editProfileModal"><i class="bi bi-pencil-square me-1"></i> Edit Nama</button>
            </div>
            <form action="/api/logout" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger rounded-pill px-4 fw-bold">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            <ul class="nav flex-column gap-2">
                <li class="nav-item">
                    <a class="nav-link fw-bold text-success {{ request()->is('dashboard-mitra') ? 'active' : '' }}" href="{{ route('mitra.dashboard') }}"><i class="bi bi-grid me-2"></i> Ringkasan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('mitra/hasil-panen') ? 'fw-bold text-success' : 'text-dark' }}" href="{{ route('mitra.products') }}"><i class="bi bi-box-seam me-2"></i> Hasil Panen Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('mitra/pesanan') ? 'fw-bold text-success' : 'text-dark' }}" href="{{ route('mitra.orders') }}"><i class="bi bi-cart-check me-2"></i> Daftar Pesanan</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10 main-content">
            <h3 class="fw-bold mb-4">Dashboard Utama</h3>
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="text-muted small fw-bold">Total Pendapatan</div>
                        <h2 class="fw-bold text-success my-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                        <div class="small text-muted">Bulan ini</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="text-muted small fw-bold">Pesanan Aktif</div>
                        <h2 class="fw-bold text-dark my-2">{{ $activeOrdersCount }}</h2>
                        <div class="small text-muted">Perlu diproses/dikirim</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="text-muted small fw-bold">Produk Tayang</div>
                        <h2 class="fw-bold text-dark my-2">{{ $totalProducts }}</h2>
                        <div class="small text-muted">Tersedia di PanenHub</div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold m-0">Produk Terbaru</h4>
                <a href="{{ route('mitra.products') }}" class="btn btn-outline-success fw-bold px-4 rounded-pill">Kelola Semua Produk <i class="bi bi-arrow-right ms-1"></i></a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($products->isEmpty())
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <div class="mb-3"><i class="bi bi-box-seam fs-1 text-success"></i></div>
                    <h5 class="fw-bold">Belum Ada Hasil Panen</h5>
                    <p class="text-muted">Mulai daftarkan beras atau hasil tani Anda agar bisa dibeli.</p>
                    <a href="{{ route('mitra.products') }}" class="btn btn-success fw-bold px-4 rounded-pill">Kelola Produk <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
            @else
            <div class="row g-3 mb-4">
                @foreach($products as $product)
                <div class="col-md-4 fade-in">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top rounded-top-4" alt="{{ $product->name }}" style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
                            <p class="text-success fw-bold mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="d-flex justify-content-between text-muted small">
                                <span>Kategori: {{ $product->category }}</span>
                                <span>Stok: {{ $product->stock }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Edit Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success"><i class="bi bi-person-gear me-2"></i> Pengaturan Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">Nama Mitra / Usaha</label>
                        <input type="text" name="name" class="form-control bg-light border-0 py-2" value="{{ Auth::user()->name }}" required>
                        <div class="form-text small">Nama ini akan muncul pada setiap produk yang Anda jual.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill py-2">Perbarui Profil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
