<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini tempat kamu mendaftarkan semua route untuk PanenHub.
|
*/

// --- HALAMAN UTAMA ---
// Menampilkan maksimal 3 produk beras hasil petani lokal ke pengunjung
Route::get('/', function () {
    $products = Product::latest()->get(); 
    return view('home', compact('products'));
})->name('home');


// --- AUTHENTICATION API ---
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/register-mitra', [AuthController::class, 'registerMitra']);
Route::post('/api/login', [AuthController::class, 'login']);
Route::post('/api/logout', [AuthController::class, 'logout']);

// --- SOCIAL LOGIN ROUTES ---
Route::get('/auth/{provider}/redirect', [AuthController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback']);


// --- HALAMAN FORM (TAMBAH PRODUK) ---
// Route untuk menampilkan halaman form tambah hasil panen
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');


// --- ROUTE TERPROTEKSI (HARUS LOGIN) ---
Route::middleware('auth')->group(function () {

    // Halaman Dashboard Utama Mitra Tani
    Route::get('/dashboard-mitra', function () {
        $userId = \Illuminate\Support\Facades\Auth::id();
        $products = \App\Models\Product::where('user_id', $userId)->latest()->take(3)->get();
        $totalProducts = \App\Models\Product::where('user_id', $userId)->count();
        
        $activeOrdersCount = \App\Models\Order::where('mitra_id', $userId)
                                ->whereIn('status', ['menunggu', 'diproses'])->count();
                                
        $totalRevenue = \App\Models\Order::where('mitra_id', $userId)
                                ->where('status', 'selesai')->sum('total_price');

        return view('mitra.dashboard', compact('products', 'totalProducts', 'activeOrdersCount', 'totalRevenue'));
    })->name('mitra.dashboard');

    // Halaman Hasil Panen Saya
    Route::get('/mitra/hasil-panen', function () {
        $products = \App\Models\Product::where('user_id', \Illuminate\Support\Facades\Auth::id())->latest()->get();
        return view('mitra.products', compact('products'));
    })->name('mitra.products');

    // Halaman Daftar Pesanan (Mitra)
    Route::get('/mitra/pesanan', function (Illuminate\Http\Request $request) {
        $status = $request->query('status');
        $query = \App\Models\Order::with(['buyer', 'items'])
                    ->where('mitra_id', \Illuminate\Support\Facades\Auth::id());
        
        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->get();
        return view('mitra.orders', compact('orders', 'status'));
    })->name('mitra.orders');

    // Halaman Pesanan Saya (Pembeli)
    Route::get('/buyer/orders', function () {
        $orders = \App\Models\Order::with(['items', 'mitra'])
                    ->where('buyer_id', \Illuminate\Support\Facades\Auth::id())
                    ->latest()
                    ->get();
        return view('buyer.orders', compact('orders'));
    })->name('buyer.orders');

    // --- API MANAJEMEN PRODUK (CRUD) ---
    Route::get('/api/products', [ProductController::class, 'index']); 
    Route::post('/api/products/store', [ProductController::class, 'store'])->name('product.store'); 
    Route::post('/api/products/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::post('/api/products/{id}/delete', [ProductController::class, 'destroy'])->name('product.destroy');

    // --- API ORDER MITRA ---
    Route::post('/api/orders/{id}/next-status', [\App\Http\Controllers\OrderController::class, 'nextStatus'])->name('order.nextStatus');

    // --- CHECKOUT API ---
    Route::post('/api/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');

    // --- PROFILE UPDATE ---
    Route::post('/api/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
});