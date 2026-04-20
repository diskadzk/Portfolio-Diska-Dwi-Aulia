<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'address' => 'required|string',
            'notes' => 'nullable|string',
            'cart' => 'required|json',
        ]);

        $cart = json_decode($request->cart, true);

        if (empty($cart)) {
            return back()->withErrors(['Keranjang belanja Anda kosong.']);
        }

        DB::beginTransaction();

        try {
            // Kelompokkan item berdasarkan Mitra Order
            $mitraOrders = [];
            foreach ($cart as $item) {
                $productId = null;
                $mitraId = null;
                
                if (str_starts_with($item['id'], 'product-')) {
                    $productId = (int) str_replace('product-', '', $item['id']);
                    $product = Product::find($productId);
                    if ($product) {
                        $mitraId = $product->user_id;
                        
                        if ($product->stock >= $item['qty']) {
                            $product->decrement('stock', $item['qty']);
                        } else {
                            $product->update(['stock' => 0]);
                        }
                    }
                }

                if (!$mitraId) {
                    $dummyMitra = User::where('role', 'mitra')->first();
                    $mitraId = $dummyMitra ? $dummyMitra->id : Auth::id();
                }

                if (!isset($mitraOrders[$mitraId])) {
                    $mitraOrders[$mitraId] = [
                        'total_price' => 0,
                        'items' => []
                    ];
                }

                $qty = (int)$item['qty'];
                $price = (int)$item['price'];
                $lineTotal = $price * $qty;

                $mitraOrders[$mitraId]['items'][] = [
                    'product_id' => $productId,
                    'product_name' => collect(explode(' ', $item['name']))->take(3)->implode(' '),
                    'product_image' => $item['image'],
                    'price' => $price,
                    'quantity' => $qty,
                ];

                $mitraOrders[$mitraId]['total_price'] += $lineTotal;
            }

            foreach ($mitraOrders as $mitraId => $orderData) {
                $order = Order::create([
                    'order_number' => 'PH-' . strtoupper(uniqid()),
                    'buyer_id' => Auth::id(),
                    'mitra_id' => $mitraId,
                    'total_price' => $orderData['total_price'],
                    'status' => 'menunggu',
                    'payment_method' => $request->payment_method,
                    'address' => $request->address,
                    'notes' => $request->notes,
                ]);

                foreach ($orderData['items'] as $it) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $it['product_id'],
                        'product_name' => $it['product_name'],
                        'product_image' => $it['product_image'],
                        'price' => $it['price'],
                        'quantity' => $it['quantity'],
                    ]);
                }
            }

            DB::commit();

            return back()->with('success', 'Checkout berhasil! Pesanan Anda telah diteruskan ke Mitra Tani.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage()]);
        }
    }

    public function nextStatus($id)
    {
        $order = Order::findOrFail($id);
        
        // Pastikan hanya mitra yang bersangkutan yang bisa proses
        if ($order->mitra_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $newStatus = $order->status;

        if ($order->status == 'menunggu') {
            $order->update(['status' => 'diproses']);
            $newStatus = 'diproses';
        } elseif ($order->status == 'diproses') {
            $order->update(['status' => 'dikirim']);
            $newStatus = 'dikirim';
        } elseif ($order->status == 'dikirim') {
            $order->update(['status' => 'selesai']);
            $newStatus = 'selesai';
        }

        return redirect()->route('mitra.orders', ['status' => $newStatus])->with('success', 'Status pesanan ' . $order->order_number . ' berhasil diperbarui!');
    }
}
