<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya | PanenHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-green: #2e7d32;
            --soft-bg: #f4fdf6;
        }
        body { 
            background-color: #f8faf9; 
            font-family: 'Segoe UI', sans-serif; 
            color: #333; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar { background: #fff !important; border-bottom: 2px solid var(--primary-green); padding: 12px 0; }
        .navbar-brand { font-size: 1.5rem; color: var(--primary-green) !important; font-weight: bold; }
        
        .order-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; flex: 1; }
        .page-title { font-weight: 800; color: #1a1a1a; margin-bottom: 35px; font-size: 2.2rem; text-align: center; }
        
        .order-card {
            background: #fff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            margin-bottom: 25px;
            overflow: hidden;
            transition: 0.3s;
        }
        .order-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.08); }
        
        .order-header {
            padding: 20px 25px;
            background: #fafafa;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .mitra-info { display: flex; align-items: center; gap: 10px; font-weight: 700; color: var(--primary-green); }
        .order-status {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 800;
            padding: 6px 16px;
            border-radius: 50px;
            letter-spacing: 0.5px;
        }
        .status-menunggu { background: #fff3e0; color: #e65100; }
        .status-diproses { background: #e3f2fd; color: #1565c0; }
        .status-dikirim { background: #f3e5f5; color: #7b1fa2; }
        .status-selesai { background: #e8f5e9; color: #2e7d32; }
        
        .order-body { padding: 25px; }
        .product-item { display: flex; gap: 20px; margin-bottom: 20px; align-items: center; }
        .product-img { width: 80px; height: 80px; border-radius: 12px; object-fit: cover; border: 1px solid #eee; }
        .product-details { flex: 1; display: flex; justify-content: space-between; align-items: center; }
        .product-name { font-weight: 700; font-size: 1.1rem; margin-bottom: 4px; }
        .product-meta { font-size: 0.85rem; color: #888; }
        .price-total { font-weight: 800; font-size: 1.1rem; color: #333; }
        
        .order-footer {
            padding: 30px;
            border-top: 1px dashed #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
        }
        .total-label { font-size: 0.9rem; color: #666; }
        .total-amount { font-size: 1.3rem; font-weight: 900; color: var(--primary-green); }
        
        .btn-detail {
            background: var(--primary-green);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 700;
            transition: 0.3s;
        }
        .btn-detail:hover { background: #1b5e20; color: white; transform: scale(1.05); }

        .empty-orders {
            text-align: center;
            padding: 100px 20px;
            background: #fff;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }
        .empty-orders i { font-size: 5rem; color: #e0e0e0; margin-bottom: 20px; display: block; }
        .btn-shop {
            background: var(--primary-green);
            color: white;
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            box-shadow: 0 10px 20px rgba(46, 125, 50, 0.2);
        }
    </style>
</head>
<body>

<nav class="navbar sticky-top shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logo-icon.png') }}" alt="Logo" style="height: 30px; width: auto; margin-right: 8px;">
            PanenHub
        </a>
        <div class="d-flex align-items-center gap-3">
            <span class="fw-bold me-2">Hai, {{ Auth::user()->name }}</span>
            <a href="{{ route('home') }}" class="btn btn-outline-success rounded-pill px-4 fw-bold">Belanja Lagi</a>
        </div>
    </div>
</nav>

<div class="order-container">
    <h2 class="page-title">Pesanan Saya</h2>

    @if($orders->isEmpty())
    <div class="empty-orders">
        <i class="bi bi-bag-x"></i>
        <h3 class="fw-bold">Belum ada pesanan</h3>
        <p class="text-muted">Ayo dukung petani lokal dengan belanja hasil tani terbaik!</p>
        <a href="{{ route('home') }}" class="btn-shop">Mulai Belanja</a>
    </div>
    @else
        @foreach($orders as $order)
        <div class="order-card" style="border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <div class="order-header" style="padding: 15px 20px; border-bottom: 1px solid #f0f0f0; background: #fafafa;">
                <div class="mitra-info text-dark" style="font-weight: 500; font-size: 0.95rem;">
                    <span class="badge bg-success me-2">Star</span>
                    <span class="fw-bold me-2">{{ $order->mitra->name ?? 'Mitra PanenHub' }}</span>
                    <i class="bi bi-chat-dots-fill text-success fs-5 cursor-pointer"></i>
                    <button class="btn btn-outline-secondary btn-sm ms-3" style="font-size: 0.75rem; padding: 2px 8px; border-radius: 2px;"><i class="bi bi-shop"></i> Kunjungi Toko</button>
                </div>
                <div class="d-flex align-items-center">
                    <div class="small text-muted me-3 border-end pe-3">No: <span class="fw-bold">{{ $order->order_number }}</span></div>
                    <div class="order-status status-{{ $order->status }}" style="font-size:0.85rem; padding:0; background:none; color:var(--primary-green);">
                        @if($order->status == 'menunggu') <i class="bi bi-hourglass-split"></i> MENUNGGU KONFIRMASI
                        @elseif($order->status == 'diproses') <i class="bi bi-box-seam"></i> SEDANG DIKEMAS
                        @elseif($order->status == 'dikirim') <i class="bi bi-truck"></i> SEDANG DIKIRIM
                        @elseif($order->status == 'selesai') <i class="bi bi-patch-check-fill"></i> SELESAI
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="order-body" style="padding: 0;">
                
                <div class="px-4 py-3 border-bottom border-light">
                    @foreach($order->items as $item)
                    <div class="product-item" style="border-bottom: 1px dashed #eee; padding-bottom: 15px; margin-bottom: 15px;">
                        <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}" class="product-img" style="border-radius: 2px; width: 80px; height: 80px; border: 1px solid #eee;">
                        <div class="product-details" style="align-items: flex-start;">
                            <div style="flex: 1;">
                                <div class="product-name text-dark fw-bold" style="font-size: 1rem;">{{ $item->product_name }}</div>
                                <div class="small text-muted mb-2">Bebas Pengembalian 7 Hari</div>
                                <div class="product-meta fw-bold">x{{ $item->quantity }}</div>
                                <span class="badge border border-success border-opacity-50 text-success rounded-1 bg-success-subtle mt-2"><i class="bi bi-lightning-fill text-warning"></i> PanenHub Extra</span>
                            </div>
                            <div class="price-total d-flex align-items-center h-100 mt-2">
                                <span class="text-success fw-bold fs-5">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="order-footer" style="padding: 20px 24px; background: #fffdf9; display: flex; justify-content: space-between; align-items: center;">
                <div class="text-muted small">
                    {{ $order->created_at->format('d M Y, H:i') }} • Metode Pembayaran: <span class="fw-bold">{{ strtoupper($order->payment_method) }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-4 d-flex align-items-center gap-2">
                        <span class="text-dark small"><i class="bi bi-shield-check text-success"></i> Total Pesanan:</span>
                        <span class="total-amount fs-3 text-success fw-bold m-0" style="line-height:1;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div style="min-width: 200px;">
                        <button class="btn btn-success fw-bold shadow-sm mb-2 w-100" style="border-radius: 2px; background: var(--primary-green);">Beli Lagi</button>
                        <button class="btn btn-outline-secondary btn-sm w-100" style="border-radius: 2px;">Tampilkan Rincian Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

<footer class="py-4 text-center text-muted border-top bg-white">
    <div class="container">
        <p class="mb-0 small">© 2026 PanenHub Project. Membantu petani, memberi kebaikan.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
