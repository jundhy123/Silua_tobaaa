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

        return back()->with('success', 'Produk berhasil masuk troli!');
    }

    // 2. UPDATE JUMLAH
    public function update(Request $request, Cart $cart) {
        if (auth()->id() !== $cart->user_id) {
            return back()->with('error', 'Unauthorized');
        }

        if ($request->action == 'plus') {
            $cart->increment('quantity');
        } else if ($request->action == 'minus' && $cart->quantity > 1) {
            $cart->decrement('quantity');
        }

        return back();
    }

    // 3. HAPUS ITEM
    public function destroy(Cart $cart) {
        if (auth()->id() !== $cart->user_id) {
            return back()->with('error', 'Unauthorized');
        }

        $cart->delete();
        return back();
    }

    // 4. DIRECT ORDER (Langsung ke WA tanpa masuk cart)
    public function directOrder(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_name' => 'required|string',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0'
        ]);

        $user = Auth::user();

        try {
            $order = null;
            DB::transaction(function () use ($user, $request, &$order) {
                
                // BUAT ORDER
                $order = Order::create([
                    'user_id'     => $user->id,
                    'total_price' => $request->total_price,
                    'status'      => 'pending'
                ]);

                // DETAIL ORDER
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $request->product_id,
                    'quantity'   => $request->quantity,
                    'price'      => $request->price
                ]);
            });

            // FORMAT PESAN WHATSAPP
            $adminWA = "6285361839192"; // Nomor WA Admin Silua Toba
            
            $message = "Halo Admin Silua Toba!%0A%0A";
            $message .= "🛍️ *PESANAN LANGSUNG* 🛍️%0A";
            $message .= "✅ *Pesanan sudah masuk ke database kami* %0A";
            $message .= "─────────────────%0A";
            $message .= "*ID Pesanan:* #" . $order->id . "%0A";
            $message .= "*Nama Pelanggan:* " . $user->name . "%0A";
            $message .= "*No. HP:* " . ($user->phone ?? 'Tidak ada') . "%0A%0A";
            
            $message .= "*📦 DETAIL PRODUK:*%0A";
            $message .= "• " . $request->product_name . "%0A";
            $message .= "  Qty: " . $request->quantity . " | Harga: Rp " . number_format($request->price, 0, ',', '.') . "%0A";
            $message .= "  Subtotal: Rp " . number_format($request->total_price, 0, ',', '.') . "%0A";
            
            $message .= "%0A─────────────────%0A";
            $message .= "*💰 TOTAL HARGA:* Rp " . number_format($request->total_price, 0, ',', '.') . "%0A%0A";
            $message .= "Mohon instruksi pembayaran. Terima kasih!";

            // BUAT URL WHATSAPP
            $whatsappUrl = "https://wa.me/{$adminWA}?text={$message}";

            // Return JSON dengan URL
            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'message' => 'Pesanan berhasil dibuat!',
                'whatsapp_url' => $whatsappUrl
            ])->header('Location', $whatsappUrl);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // 5. CHECKOUT
    public function checkout() {
        $user = Auth::user();

        $cartItems = Cart::where('user_id', $user->id)
                        ->with('product')
                        ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Troli Anda masih kosong!');
        }

        try {
            $order = null;
            DB::transaction(function () use ($user, $cartItems, &$order) {
                
                // HITUNG TOTAL
                $totalPrice = 0;
                foreach ($cartItems as $item) {
                    $totalPrice += ($item->product->price * $item->quantity);
                }

                // BUAT ORDER
                $order = Order::create([
                    'user_id'     => $user->id,
                    'total_price' => $totalPrice,
                    'status'      => 'pending'
                ]);

                // DETAIL ORDER
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity,
                        'price'      => $item->product->price
                    ]);
                }

                // KOSONGKAN CART
                Cart::where('user_id', $user->id)->delete();
            });

            // FORMAT PESAN WHATSAPP DENGAN DETAIL ITEMS
            $adminWA = "6285361839192"; // Nomor WA Admin Silua Toba
            
            $message = "Halo Admin Silua Toba!%0A%0A";
            $message .= "🛍️ *PESANAN BARU* 🛍️%0A";
            $message .= "─────────────────%0A";
            $message .= "*ID Pesanan:* #" . $order->id . "%0A";
            $message .= "*Nama Pelanggan:* " . $user->name . "%0A";
            $message .= "*No. HP:* " . ($user->phone ?? 'Tidak ada') . "%0A%0A";
            
            $message .= "*📦 DETAIL PRODUK:*%0A";
            foreach ($cartItems as $item) {
                $subtotal = $item->product->price * $item->quantity;
                $message .= "• " . $item->product->name . "%0A";
                $message .= "  Qty: " . $item->quantity . " | Harga: Rp " . number_format($item->product->price, 0, ',', '.') . "%0A";
                $message .= "  Subtotal: Rp " . number_format($subtotal, 0, ',', '.') . "%0A";
            }
            
            $message .= "%0A─────────────────%0A";
            $message .= "*💰 TOTAL HARGA:* Rp " . number_format($order->total_price, 0, ',', '.') . "%0A%0A";
            $message .= "Mohon instruksi pembayaran. Terima kasih!";

            // REDIRECT KE WHATSAPP
            return redirect("https://wa.me/{$adminWA}?text={$message}");

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat checkout.');
        }
    }
}