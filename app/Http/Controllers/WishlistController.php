<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Tampilkan Halaman Wishlist
    public function index() {
        $wishlists = Wishlist::where('user_id', Auth::id())
                        ->with(['product.reviews.user'])
                        ->latest()
                        ->get();
        return view('user.wishlist', compact('wishlists'));
    }

    // Tambah atau Hapus Wishlist (Toggle)
    public function toggle(Request $request) {
        $data = [
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ];

        $check = Wishlist::where($data)->first();

        if ($check) {
            $check->delete();
            return back()->with('success', 'Dihapus dari Wishlist');
        } else {
            Wishlist::create($data);
            return back()->with('success', 'Berhasil simpan ke Wishlist');
        }
    }
}
