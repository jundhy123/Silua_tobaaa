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
    // 1. TAMBAH KE KERANJANG
    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $request->product_id)
                    ->first();

        if ($cart) {
            $cart->increment('quantity', $request->quantity);
        } else {
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

    // 2. UPDATE JUMLAH (PLUS/MINUS)
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

    // 3. HAPUS ITEM
    public function destroy(Cart $cart) {
        if (auth()->id() !== $cart->user_id) {
            return back()->with('error', 'Akses ditolak');
        }

        $cart->delete();
        return back();
    }

    /**
     * 4. PESANAN SAYA (RIWAYAT & TRACKING)
     * Tambahan fungsi untuk fitur pelacakan pesanan
     */
    public function myOrders()
    {
        // Mengambil pesanan milik user yang sedang login
        // 'items.product' berasumsi relasi di model Order bernama 'items'
        $orders = Order::where('user_id', Auth::id())
                       ->with('items.product')
                       ->latest()
                       ->get();

        return view('user.orders', compact('orders'));
    }

    // 5. DIRECT ORDER (Pesan Sekarang dari Modal Detail)
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
            $message = "✨ *PESANAN LANGSUNG - SILUA TOBA* ✨\n";
            $message .= "--------------------------------------------\n";
            $message .= "🆔 *Order ID:* #{$order->id}\n";
            $message .= "👤 *Nama:* {$user->name}\n";
            $message .= "📞 *No. HP:* " . ($user->phone ?? '-') . "\n";
            $message .= "--------------------------------------------\n\n";
            $message .= "🛒 *Item:* \n";
            $message .= "• {$product->name}\n";
            $message .= "  {$request->quantity} x Rp " . number_format($product->price, 0, ',', '.') . "\n\n";
            $message .= "💰 *TOTAL TAGIHAN: Rp " . number_format($totalPrice, 0, ',', '.') . "*\n";
            $message .= "--------------------------------------------\n";
            $message .= "Mohon instruksi selanjutnya ya Admin. Terima kasih!";

            return redirect("https://wa.me/{$adminWA}?text=" . urlencode($message));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    // 6. CHECKOUT (Dari Troli Samping)
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

                Cart::where('user_id', $user->id)->delete();

                return $newOrder;
            });

            $adminWA = "6285361839192";
            $message = "✨ *PESANAN BARU - SILUA TOBA* ✨\n";
            $message .= "--------------------------------------------\n";
            $message .= "🆔 *Order ID:* #{$order->id}\n";
            $message .= "👤 *Nama:* {$user->name}\n";
            $message .= "📞 *No. HP:* " . ($user->phone ?? '-') . "\n";
            $message .= "--------------------------------------------\n\n";
            $message .= "🛒 *Daftar Belanja:* \n";

            foreach ($cartItems as $item) {
                $subtotal = $item->product->price * $item->quantity;
                $message .= "• {$item->product->name} (x{$item->quantity})\n";
                $message .= "  Subtotal: Rp " . number_format($subtotal, 0, ',', '.') . "\n";
            }

            $message .= "\n💰 *TOTAL AKHIR: Rp " . number_format($order->total_price, 0, ',', '.') . "*\n";
            $message .= "--------------------------------------------\n";
            $message .= "Mohon konfirmasi pesanannya Admin 🙏";

            return redirect("https://wa.me/{$adminWA}?text=" . urlencode($message));

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat checkout.');
        }
    }
}
