<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Menambahkan produk ke dalam keranjang belanja (troli)
     */
    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $request->product_id)
                    ->first();

        // Jika produk sudah ada di keranjang, tambah jumlahnya
        if ($cart) {
            $cart->increment('quantity', $request->quantity);
        } else {
            // Jika belum ada, buat baris baru di tabel keranjang
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil masuk troli!',
                'cart_count' => Cart::where('user_id', Auth::id())->sum('quantity')
            ]);
        }

        return back()->with('success', 'Produk berhasil masuk troli!');
    }

    /**
     * Memperbarui jumlah produk (tambah/kurang) langsung dari sidebar keranjang
     */
    public function update(Request $request, Cart $cart) {
        if (auth()->id() !== $cart->user_id) {
            return back()->with('error', 'Akses ditolak');
        }

        if ($request->action == 'plus') {
            $cart->increment('quantity');
        } else if ($request->action == 'minus' && $cart->quantity > 1) {
            $cart->decrement('quantity');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => Cart::where('user_id', Auth::id())->sum('quantity')
            ]);
        }

        return back();
    }

    /**
     * Menghapus item tertentu dari keranjang belanja
     */
    public function destroy(Cart $cart) {
        if (auth()->id() !== $cart->user_id) {
            return back()->with('error', 'Akses ditolak');
        }

        $cart->delete();
        return back();
    }

    /**
     * Menampilkan riwayat pesanan milik pelanggan yang sedang login
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->with('items.product')
                       ->latest()
                       ->get();

        return view('user.orders', compact('orders'));
    }

    /**
     * Fitur 'Beli Sekarang' - Membuat pesanan instan tanpa lewat keranjang
     */
    public function directOrder(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);
        $totalPrice = $product->price * $request->quantity;

        try {
            $order = DB::transaction(function () use ($user, $request, $product, $totalPrice) {
                $newOrder = Order::create([
                    'user_id'     => $user->id,
                    'total_price' => $totalPrice,
                    'status'      => 'pending'
                ]);

                OrderItem::create([
                    'order_id'   => $newOrder->id,
                    'product_id' => $product->id,
                    'quantity'   => $request->quantity,
                    'price'      => $product->price
                ]);

                return $newOrder;
            });

            $adminWA = "6285361839192";
            // Format pesan rapi untuk dikirim ke WhatsApp Admin
            $message = "📦 *PESANAN BARU (LANGSUNG)* 📦\n";
            $message .= "------------------------------------------\n";
            $message .= "🆔 *Order ID:* #{$order->id}\n";
            $message .= "👤 *Pelanggan:* {$user->name}\n";
            $message .= "------------------------------------------\n\n";
            $message .= "🛒 *Detail Produk:* \n";
            $message .= "• *{$product->name}*\n";
            $message .= "  Qty: {$request->quantity} x Rp " . number_format($product->price, 0, ',', '.') . "\n\n";
            $message .= "💰 *TOTAL BAYAR: Rp " . number_format($totalPrice, 0, ',', '.') . "*\n";
            $message .= "------------------------------------------\n";
            $message .= "Mohon konfirmasi pesanan saya ya Admin, Terima kasih! 🙏";

            return redirect("https://wa.me/{$adminWA}?text=" . urlencode($message));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Finalisasi belanja (Checkout) dari semua isi keranjang ke WhatsApp
     */
    public function checkout() {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Troli Anda kosong!');
        }

        try {
            $order = DB::transaction(function () use ($user, $cartItems) {
                $totalPrice = $cartItems->sum(function($item) {
                    return $item->product->price * $item->quantity;
                });

                $newOrder = Order::create([
                    'user_id'     => $user->id,
                    'total_price' => $totalPrice,
                    'status'      => 'pending'
                ]);

                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id'   => $newOrder->id,
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity,
                        'price'      => $item->product->price
                    ]);
                }

                // Kosongkan keranjang setelah checkout berhasil
                Cart::where('user_id', $user->id)->delete();

                return $newOrder;
            });

            $adminWA = "6285361839192";
            $message = "🛍️ *PESANAN BARU (TROLI)* 🛍️\n";
            $message .= "------------------------------------------\n";
            $message .= "🆔 *Order ID:* #{$order->id}\n";
            $message .= "👤 *Pelanggan:* {$user->name}\n";
            $message .= "------------------------------------------\n\n";
            $message .= "🛒 *Daftar Belanja:* \n";

            foreach ($cartItems as $item) {
                $subtotal = $item->product->price * $item->quantity;
                $message .= "• *{$item->product->name}* (x{$item->quantity})\n";
                $message .= "  Subtotal: Rp " . number_format($subtotal, 0, ',', '.') . "\n";
            }

            $message .= "\n💰 *TOTAL AKHIR: Rp " . number_format($order->total_price, 0, ',', '.') . "*\n";
            $message .= "------------------------------------------\n";
            $message .= "Mohon segera diproses ya Admin, Terima kasih! 🙏";

            return redirect("https://wa.me/{$adminWA}?text=" . urlencode($message));

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat checkout.');
        }
    }
}
