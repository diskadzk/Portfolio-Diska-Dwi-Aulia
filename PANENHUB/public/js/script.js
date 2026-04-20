const SESSION_KEY = "active_user";
let cart = [];
let currentUser = JSON.parse(sessionStorage.getItem(SESSION_KEY));

document.addEventListener("DOMContentLoaded", () => {
    renderNavbar();
    updateCartBadge();
    
    const regForm = document.getElementById('regForm');
    const loginForm = document.getElementById('loginForm');
    
    if(regForm) regForm.addEventListener('submit', registerUser);
    if(loginForm) loginForm.addEventListener('submit', loginUser);
});

// Auth Handlers
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
        el.innerHTML = `
            <div class="dropdown">
                <button class="btn btn-outline-success dropdown-toggle btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="dropdown">
                    Hi, ${currentUser.name}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item small" href="javascript:void(0)" onclick="logout()">Logout</a></li>
                </ul>
            </div>`;
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
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    });

    const result = await res.json();
    if (res.ok) {
        alert("Register berhasil! Silakan login.");
        openLogin();
    } else {
        alert(result.message);
    }
}

async function loginUser(e) {
    e.preventDefault();
    const data = {
        user: document.getElementById('l_user').value,
        pass: document.getElementById('l_pass').value
    };

    const res = await fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    });

    const result = await res.json();
    if (res.ok) {
        currentUser = result.user;
        sessionStorage.setItem(SESSION_KEY, JSON.stringify(result.user));
        location.reload();
    } else {
        alert(result.message);
    }
}

async function logout() {
    await fetch('/api/logout', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
    sessionStorage.clear();
    location.reload();
}

// Cart Logic
function addToCart(name, price, img) {
    if (!currentUser) {
        alert("Login dulu bos!");
        return openLogin();
    }
    const existing = cart.find(i => i.name === name);
    if (existing) existing.qty++;
    else cart.push({ name, price: parseInt(price), img, qty: 1 });
    
    updateCartBadge();
    alert(`🛒 ${name} masuk keranjang!`);
}

function updateCartBadge() {
    const badge = document.getElementById('cartBadge');
    const count = cart.reduce((s, i) => s + i.qty, 0);
    badge.innerText = count;
    badge.style.display = count > 0 ? 'block' : 'none';
}

function showCart() {
    if (!currentUser) return openLogin();
    const container = document.getElementById('cartItemsContainer');
    if (cart.length === 0) return alert("Keranjang kosong!");

    container.innerHTML = '';
    let total = 0;
    cart.forEach((item, idx) => {
        const sub = item.price * item.qty;
        total += sub;
        container.innerHTML += `
            <tr>
                <td class="ps-4"><img src="${item.img}" class="cart-item-img me-2"> ${item.name}</td>
                <td>Rp ${item.price.toLocaleString()}</td>
                <td>${item.qty}</td>
                <td class="text-success fw-bold">Rp ${sub.toLocaleString()}</td>
                <td><button class="btn btn-sm text-danger" onclick="removeItem(${idx})">Hapus</button></td>
            </tr>`;
    });
    document.getElementById('totalPriceDisplay').innerText = `Rp ${total.toLocaleString()}`;
    bootstrap.Modal.getOrCreateInstance(document.getElementById('cartModal')).show();
}

function removeItem(idx) {
    cart.splice(idx, 1);
    updateCartBadge();
    showCart();
}

function handleSearch() {
    const q = document.getElementById('productSearch').value.toLowerCase();
    document.querySelectorAll('.product-item').forEach(p => {
        const name = p.querySelector('.product-name').innerText.toLowerCase();
        p.style.display = name.includes(q) ? 'block' : 'none';
    });
}