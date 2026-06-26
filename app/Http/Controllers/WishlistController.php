<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Menampilkan halaman daftar produk favorit (Wishlist) milik pelanggan
     */
    public function index() {
        // Mengambil data wishlist beserta ulasan produknya agar modal detail berfungsi penuh
        $wishlists = Wishlist::where('user_id', Auth::id())
                        ->with(['product.reviews.user'])
                        ->latest()
                        ->get();
        return view('user.wishlist', compact('wishlists'));
    }

    /**
     * Menambah ke favorit jika belum ada, atau menghapus jika sudah ada (Toggle System)
     */
    public function toggle(Request $request) {
        $data = [
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ];

        // Cek keberadaan produk di tabel wishlist untuk user yang login
        $check = Wishlist::where($data)->first();

        if ($check) {
            // Jika data ditemukan, maka dihapus (Un-wishlist)
            $check->delete();
            return back()->with('success', 'Dihapus dari Wishlist');
        } else {
            // Jika data tidak ada, maka dibuat baru (Add to Wishlist)
            Wishlist::create($data);
            return back()->with('success', 'Berhasil simpan ke Wishlist');
        }
    }
}
