import './bootstrap';

window.openLogin = function() { new bootstrap.Modal(document.getElementById('loginModal')).show(); }
window.openRegister = function() { new bootstrap.Modal(document.getElementById('registerModal')).show(); }
window.openMitraModal = function() { new bootstrap.Modal(document.getElementById('mitraModal')).show(); }
window.openCart = function() { renderCart(); new bootstrap.Modal(document.getElementById('cartModal')).show(); }
window.socialLogin = function(platform) { alert("Menghubungkan ke " + platform + "... (Fitur ini akan aktif setelah integrasi API)");}

window.filterProducts = function() {
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

window.switchMitraTab = function(tab) {
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

window.getCart = function() {
    var raw = JSON.parse(localStorage.getItem('panenhub_cart') || '[]');
    var clean = raw.filter(function(item) {
        return item && item.id && item.name && item.price && item.image && item.mitra;
    });
    if (clean.length !== raw.length) {
        localStorage.setItem('panenhub_cart', JSON.stringify(clean));
    }
    return clean;
}

window.saveCart = function(cart) {
    localStorage.setItem('panenhub_cart', JSON.stringify(cart));
    updateCartBadge();
}

// NOTE: isAuthenticated must be globally defined before calling this
window.addToCart = function(id, name, price, image, mitra) {
    if (typeof window.isAuthenticated !== 'undefined' && !window.isAuthenticated) {
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

window.removeFromCart = function(id) {
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

window.changeQty = function(id, delta) {
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

window.formatRupiah = function(num) {
    return 'Rp ' + num.toLocaleString('id-ID');
}

window.updateCartBadge = function() {
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

window.renderCart = function() {
    var cart = getCart();
    var container = document.getElementById('cartContent');
    if (!container) return;

    if (cart.length === 0) {
        container.innerHTML = '<div class="cart-empty">' +
            '<i class="bi bi-cart-x"></i>' +
            '<h5 class="fw-bold text-muted">Keranjang Kosong</h5>' +
            '<p class="small">Yuk, mulai belanja beras dari petani lokal!</p>' +
            '</div>';
        return;
    }

    var grandTotal = 0;
    var totalQty = 0;
    var rows = '';

    for (var i = 0; i < cart.length; i++) {
        var item = cart[i];
        var lineTotal = item.price * item.qty;
        grandTotal += lineTotal;
        totalQty += item.qty;

        rows += '<tr>' +
            '<td>' +
                '<div class="cart-product-cell">' +
                    '<img src="/' + item.image + '" alt="' + item.name + '" class="cart-product-img">' +
                    '<div class="cart-product-info">' +
                        '<span class="cart-mitra-badge"><span style="background:#2e7d32;color:#fff;padding:1px 5px;border-radius:3px;margin-right:4px;font-size:0.6rem;">Tani</span> ' + item.mitra + '</span>' +
                        '<span class="cart-product-name">' + item.name + '</span>' +
                        '<span class="cart-return-policy">7 Hari Pengembalian</span>' +
                    '</div>' +
                '</div>' +
            '</td>' +
            '<td class="cart-price">' + formatRupiah(item.price) + '</td>' +
            '<td>' +
                '<div class="cart-qty-control">' +
                    '<button type="button" class="cart-qty-btn" data-action="minus" data-id="' + item.id + '">&minus;</button>' +
                    '<input type="text" class="cart-qty-val" value="' + item.qty + '" readonly>' +
                    '<button type="button" class="cart-qty-btn" data-action="plus" data-id="' + item.id + '">+</button>' +
                '</div>' +
            '</td>' +
            '<td class="cart-total-price">' + formatRupiah(lineTotal) + '</td>' +
            '<td><button type="button" class="cart-delete-btn" data-action="delete" data-id="' + item.id + '"><i class="bi bi-trash3"></i></button></td>' +
        '</tr>';
    }

    container.innerHTML =
        '<table class="cart-table">' +
            '<thead><tr>' +
                '<th>Produk</th><th>Harga Satuan</th><th>Jumlah</th><th>Total Harga</th><th>Aksi</th>' +
            '</tr></thead>' +
            '<tbody>' + rows + '</tbody>' +
        '</table>' +
        '<div class="cart-voucher-row">' +
            '<div class="left"><i class="bi bi-ticket-perforated"></i> Voucher PanenHub</div>' +
            '<div class="right">Gunakan/ masukkan kode <i class="bi bi-chevron-right"></i></div>' +
        '</div>' +
        '<div class="cart-summary">' +
            '<div class="cart-summary-left">' +
                '<div class="cart-total-label">Total (' + totalQty + ' produk):</div>' +
                '<div class="cart-grand-total">' + formatRupiah(grandTotal) + '</div>' +
            '</div>' +
            '<button class="btn-checkout" id="btnCheckout">Checkout</button>' +
        '</div>';
}

window.submitCheckout = function() {
    var cart = getCart();
    if (cart.length === 0) return false;
    document.getElementById('checkoutCartData').value = JSON.stringify(cart);
    return true;
}

// Event Delegation
document.addEventListener('click', function(e) {
    var target = e.target.closest('[data-action]');
    if (!target) return;
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
        if (typeof window.isAuthenticated !== 'undefined' && !window.isAuthenticated) {
            openLogin();
            return;
        }
        if (getCart().length === 0) return;
        
        var grandTotal = 0;
        var cart = getCart();
        for (var i = 0; i < cart.length; i++) {
            grandTotal += cart[i].price * cart[i].qty;
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
});
