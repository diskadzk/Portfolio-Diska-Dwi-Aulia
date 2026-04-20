<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Panen Saya | PanenHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-green: #2e7d32;
            --muted-blue: #1e40af;
        }
        .btn-edit { color: var(--muted-blue) !important; border-color: var(--muted-blue) !important; }
        .btn-edit:hover { background-color: var(--muted-blue) !important; color: white !important; }
        .text-muted-blue { color: var(--muted-blue) !important; }
        .btn-muted-blue { background-color: var(--muted-blue); color: white; }
        .btn-muted-blue:hover { background-color: #173693; color: white; }
        body { background-color: #f4fdf6; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #fff !important; border-bottom: 2px solid var(--primary-green); padding: 12px 0; }
        .navbar-brand { font-size: 1.5rem; color: var(--primary-green) !important; font-weight: bold; }
        .sidebar { background: #fff; border-right: 1px solid #ddd; height: calc(100vh - 70px); padding: 20px; position: sticky; top: 70px; }
        .main-content { padding: 40px; }
        .product-card { background: #fff; border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.06); transition: 0.3s; }
        .product-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .product-card img { height: 180px; object-fit: cover; width: 100%; }
        .badge-category { background: #e8f5e9; color: #2e7d32; font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 50px; }
        .badge-stock { background: #fff3e0; color: #e65100; font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 50px; }
        .empty-state { padding: 80px 20px; text-align: center; }
        .empty-state i { font-size: 4rem; color: #c8e6c9; margin-bottom: 15px; display: block; }
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
            <form action="/api/logout" method="POST" class="m-0" onsubmit="localStorage.removeItem('panenhub_cart')">
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
                    <a class="nav-link text-dark" href="{{ route('mitra.dashboard') }}"><i class="bi bi-grid me-2"></i> Ringkasan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-success" href="{{ route('mitra.products') }}"><i class="bi bi-box-seam me-2"></i> Hasil Panen Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('mitra.orders') }}"><i class="bi bi-cart-check me-2"></i> Daftar Pesanan</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Hasil Panen Saya</h3>
                    <p class="text-muted mb-0">Kelola semua produk hasil tani yang Anda jual di PanenHub</p>
                </div>
                <button class="btn btn-success fw-bold px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#addProductModal"><i class="bi bi-plus-lg me-1"></i> Tambah Produk Baru</button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($products->isEmpty())
            <div class="empty-state">
                <i class="bi bi-box-seam"></i>
                <h4 class="fw-bold text-muted">Belum Ada Produk</h4>
                <p class="text-muted">Anda belum mendaftarkan hasil panen. Mulai tambahkan produk pertama Anda!</p>
                <button class="btn btn-success fw-bold px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#addProductModal"><i class="bi bi-plus-lg me-1"></i> Tambah Produk Pertama</button>
            </div>
            @else

            <!-- Info Bar -->
            <div class="bg-white rounded-4 p-3 mb-4 shadow-sm d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 rounded-3 p-2 px-3">
                        <i class="bi bi-box-seam text-success fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ $products->count() }} Produk Terdaftar</div>
                        <div class="text-muted small">Total stok: {{ $products->sum('stock') }}</div>
                    </div>
                </div>
            </div>

            <!-- Product Table -->
            <div class="bg-white rounded-4 shadow-sm overflow-hidden">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr class="bg-light">
                            <th class="ps-4 py-3 text-muted small fw-bold text-uppercase" style="letter-spacing:0.5px;">Produk</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase" style="letter-spacing:0.5px;">Kategori</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase" style="letter-spacing:0.5px;">Harga</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase" style="letter-spacing:0.5px;">Stok</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center" style="letter-spacing:0.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="rounded-3" style="width: 55px; height: 55px; object-fit: cover; border: 1px solid #eee;">
                                    <div>
                                        <div class="fw-bold">{{ $product->name }}</div>
                                        <div class="text-muted small">Ditambahkan {{ $product->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-category">{{ $product->category }}</span></td>
                            <td class="fw-bold text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge-stock">{{ $product->stock }}</span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3 btn-edit" 
                                    onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ $product->category }}', {{ $product->price }}, {{ $product->stock }})">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </button>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3"><i class="bi bi-trash me-1"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success"><i class="bi bi-plus-circle me-2"></i> Tambah Hasil Panen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Nama Hasil Panen</label>
                        <input type="text" name="name" class="form-control bg-light border-0" placeholder="Contoh: Beras Pandan Wangi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Kategori</label>
                        <select name="category" class="form-select bg-light border-0" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Beras Putih">Beras Putih</option>
                            <option value="Beras Merah">Beras Merah</option>
                            <option value="Beras Ketan">Beras Ketan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control bg-light border-0" placeholder="Contoh: 15000" min="100" required>
                            <div class="form-text small text-danger">Tulis angka saja tanpa titik, contoh: 15000</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">Stok</label>
                            <input type="number" name="stock" class="form-control bg-light border-0" placeholder="Contoh: 50" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">Foto Produk</label>
                        <input type="file" name="image" class="form-control bg-light border-0" accept="image/jpeg,image/png,image/jpg" required>
                        <div class="form-text small">Format JPG/PNG, Maksimal 2MB.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill py-2">Simpan Hasil Panen</button>
                </form>
            </div>
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

<!-- Modal Edit Produk -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-muted-blue"><i class="bi bi-pencil-square me-2"></i> Edit Hasil Panen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Nama Hasil Panen</label>
                        <input type="text" name="name" id="edit_name" class="form-control bg-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Kategori</label>
                        <select name="category" id="edit_category" class="form-select bg-light border-0" required>
                            <option value="Beras Putih">Beras Putih</option>
                            <option value="Beras Merah">Beras Merah</option>
                            <option value="Beras Ketan">Beras Ketan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">Harga (Rp)</label>
                            <input type="number" name="price" id="edit_price" class="form-control bg-light border-0" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">Stok</label>
                            <input type="number" name="stock" id="edit_stock" class="form-control bg-light border-0" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">Foto Produk (Kosongkan jika tidak ingin ganti)</label>
                        <input type="file" name="image" class="form-control bg-light border-0" accept="image/jpeg,image/png,image/jpg">
                    </div>
                    <button type="submit" class="btn btn-muted-blue w-100 fw-bold rounded-pill py-2">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openEditModal(id, name, category, price, stock) {
        document.getElementById('editProductForm').action = '/api/products/' + id + '/update';
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_stock').value = stock;
        new bootstrap.Modal(document.getElementById('editProductModal')).show();
    }
</script>
</body>
</html>
