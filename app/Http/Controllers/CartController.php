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
    public function update(Request $request, $id) {
        $cart = Cart::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        if ($request->action == 'plus') {
            $cart->increment('quantity');
        } else if ($request->action == 'minus' && $cart->quantity > 1) {
            $cart->decrement('quantity');
        }

        return back();
    }

    // 3. HAPUS ITEM
    public function destroy($id) {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back();
    }

    // 4. CHECKOUT
    public function checkout() {
        $user = Auth::user();

        $cartItems = Cart::where('user_id', $user->id)
                        ->with('product')
                        ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Troli Anda masih kosong!');
        }

        try {
            DB::transaction(function () use ($user, $cartItems) {
                
                // HITUNG TOTAL
                $totalPrice = 0;
                foreach ($cartItems as $item) {
                    $totalPrice += ($item->product->price * $item->quantity);
                }

                // BUAT ORDER (🔥 FIX: TANPA order_code)
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

            return redirect()->route('user.products')
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat checkout.');
        }
    }
}