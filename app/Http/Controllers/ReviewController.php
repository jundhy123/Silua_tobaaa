<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ReviewController extends Controller implements HasMiddleware
{
    /**
     * Mengatur proteksi akses: Semua fungsi di controller ini wajib login (Auth)
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    /**
     * Menyimpan ulasan baru atau memperbarui ulasan lama jika pelanggan sudah pernah mengulas produk tersebut
     */
    public function store(Request $request)
    {
        // Validasi input: rating wajib diisi antara 1 sampai 5 bintang
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        // Menggunakan updateOrCreate agar 1 user hanya punya 1 ulasan per 1 produk
        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment
            ]
        );

        return back()->with('success', 'Ulasan berhasil disimpan!');
    }

    /**
     * Menghapus ulasan milik pelanggan
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Memastikan hanya pemilik ulasan yang bisa menghapus datanya sendiri
        if ($review->user_id != Auth::id()) {
            abort(403, 'Tidak diizinkan!');
        }

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus!');
    }
}
