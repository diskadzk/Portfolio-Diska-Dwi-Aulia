<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan | PanenHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-green: #2e7d32;
        }
        body { background-color: #f4fdf6; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #fff !important; border-bottom: 2px solid var(--primary-green); padding: 12px 0; }
        .navbar-brand { font-size: 1.5rem; color: var(--primary-green) !important; font-weight: bold; }
        .sidebar { background: #fff; border-right: 1px solid #ddd; height: calc(100vh - 70px); padding: 20px; position: sticky; top: 70px; }
        .main-content { padding: 40px; }
        .status-badge { font-size: 0.72rem; font-weight: 700; padding: 5px 14px; border-radius: 50px; }
        .status-pending { background: #fff3e0; color: #e65100; }
        .status-proses { background: #e3f2fd; color: #1565c0; }
        .status-dikirim { background: #f3e5f5; color: #7b1fa2; }
        .status-selesai { background: #e8f5e9; color: #2e7d32; }
        .empty-state { padding: 80px 20px; text-align: center; }
        .empty-state i { font-size: 4rem; color: #c8e6c9; margin-bottom: 15px; display: block; }
        .order-card { background: #fff; border-radius: 16px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.06); overflow: hidden; transition: 0.3s; }
        .order-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
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
                    <a class="nav-link text-dark" href="{{ route('mitra.products') }}"><i class="bi bi-box-seam me-2"></i> Hasil Panen Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-success" href="{{ route('mitra.orders') }}"><i class="bi bi-cart-check me-2"></i> Daftar Pesanan</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Daftar Pesanan</h3>
                    <p class="text-muted mb-0">Pantau pesanan masuk dari pelanggan PanenHub</p>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="bg-white rounded-4 shadow-sm p-3 mb-4 d-flex gap-2 align-items-center">
                <span class="text-muted small fw-bold me-2">Filter:</span>
                <a href="{{ route('mitra.orders') }}" class="btn btn-sm {{ is_null($status) ? 'btn-success fw-bold active' : 'btn-outline-secondary' }} rounded-pill px-3">Semua</a>
                <a href="{{ route('mitra.orders', ['status' => 'menunggu']) }}" class="btn btn-sm {{ $status == 'menunggu' ? 'btn-success fw-bold active' : 'btn-outline-secondary' }} rounded-pill px-3">Menunggu</a>
                <a href="{{ route('mitra.orders', ['status' => 'diproses']) }}" class="btn btn-sm {{ $status == 'diproses' ? 'btn-success fw-bold active' : 'btn-outline-secondary' }} rounded-pill px-3">Diproses</a>
                <a href="{{ route('mitra.orders', ['status' => 'dikirim']) }}" class="btn btn-sm {{ $status == 'dikirim' ? 'btn-success fw-bold active' : 'btn-outline-secondary' }} rounded-pill px-3">Dikirim</a>
                <a href="{{ route('mitra.orders', ['status' => 'selesai']) }}" class="btn btn-sm {{ $status == 'selesai' ? 'btn-success fw-bold active' : 'btn-outline-secondary' }} rounded-pill px-3">Selesai</a>
            </div>

            <!-- Empty State (shown when no orders yet) -->
            @if($orders->isEmpty())
            <div class="empty-state">
                <i class="bi bi-cart-x"></i>
                <h4 class="fw-bold text-muted">Belum Ada Pesanan</h4>
                <p class="text-muted">Pesanan dari pelanggan akan muncul di sini. Pastikan produk Anda sudah terdaftar di PanenHub!</p>
                <a href="{{ route('mitra.products') }}" class="btn btn-success fw-bold px-4 rounded-pill"><i class="bi bi-box-seam me-1"></i> Kelola Produk Saya</a>
            </div>
            @else
            <div class="bg-white rounded-4 shadow-sm overflow-hidden">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr class="bg-light">
                            <th class="ps-4 py-3 text-muted small fw-bold text-uppercase" style="letter-spacing:0.5px;">No. Pesanan</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase" style="letter-spacing:0.5px;">Pembeli</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase" style="letter-spacing:0.5px;">Produk</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase" style="letter-spacing:0.5px;">Total Transaksi</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase" style="letter-spacing:0.5px;">Waktu</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase" style="letter-spacing:0.5px;">Status</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center" style="letter-spacing:0.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="ps-4 py-3 fw-bold">{{ $order->order_number }}</td>
                            <td>
                                <div class="fw-bold">{{ $order->buyer->name }}</div>
                                <div class="small text-muted mb-1"><i class="bi bi-geo-alt me-1"></i> {{ $order->address }}</div>
                                @if($order->notes)
                                    <div class="x-small text-secondary" style="font-size: 0.75rem;"><i class="bi bi-info-circle me-1"></i> {{ $order->notes }}</div>
                                @endif
                                <div class="mt-1 small fw-bold text-success">{{ $order->payment_method }}</div>
                            </td>
                            <td>
                                @foreach($order->items as $item)
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <img src="{{ asset($item->product_image) }}" alt="img" style="width: 30px; height: 30px; object-fit:cover; border-radius:4px;">
                                        <span class="small">{{ $item->product_name }} ({{ $item->quantity }}x)</span>
                                    </div>
                                @endforeach
                            </td>
                            <td class="fw-bold text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="small text-muted">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                @if($order->status == 'menunggu')
                                    <span class="status-badge status-pending">Menunggu</span>
                                @elseif($order->status == 'diproses')
                                    <span class="status-badge status-proses">Diproses</span>
                                @elseif($order->status == 'dikirim')
                                    <span class="status-badge status-dikirim">Dikirim</span>
                                @else
                                    <span class="status-badge status-selesai">Selesai</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($order->status == 'menunggu')
                                    <form action="{{ route('order.nextStatus', $order->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3">Proses</button>
                                    </form>
                                @elseif($order->status == 'diproses')
                                    <form action="{{ route('order.nextStatus', $order->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-info rounded-pill px-3">Kirim</button>
                                    </form>
                                @elseif($order->status == 'dikirim')
                                    <form action="{{ route('order.nextStatus', $order->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success rounded-pill px-3">Selesai</button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-light text-muted rounded-pill px-3" disabled><i class="bi bi-check-all"></i> Done</button>
                                @endif
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
