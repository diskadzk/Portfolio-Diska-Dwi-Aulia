<div class="col-md-3 product-card-col fade-in">
    <div class="card card-product">
        <div class="img-container">
            <img src="{{ $product->image_url }}" alt="Gambar produk {{ $product->name }}" loading="lazy">
        </div>
        <div class="p-3">
            <div class="badge-info">{{ $product->user->name ?? 'Mitra PanenHub' }}</div>
            <div class="product-title">{{ $product->name }}</div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="product-price mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <span class="badge {{ $product->stock > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border-0">Stok: {{ $product->stock }}</span>
            </div>
            @if($product->stock > 0)
                <button class="btn-add-cart" onclick="addToCart('product-{{ $product->id }}','{{ addslashes($product->name) }}', {{ (int)$product->price }}, '{{ $product->image_url }}', '{{ addslashes($product->user->name ?? 'Mitra PanenHub') }}')">
                    <i class="bi bi-cart-plus"></i> Tambah
                </button>
            @else
                <button class="btn-add-cart" style="background:#e0e0e0; color:#888; cursor:not-allowed;" disabled>
                    <i class="bi bi-x-circle"></i> Produk Habis
                </button>
            @endif
        </div>
    </div>
</div>
