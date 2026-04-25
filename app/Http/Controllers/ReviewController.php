<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Tambahkan 2 import di bawah ini untuk Laravel 12
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ReviewController extends Controller implements HasMiddleware
{
    /**
     * Pengganti $this->middleware() di Laravel 12
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'), // Semua fungsi di controller ini wajib login
        ];
    }

    // ==============================
    // SIMPAN / UPDATE ULASAN
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

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

    // ==============================
    // HAPUS ULASAN
    // ==============================
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id != Auth::id()) {
            abort(403, 'Tidak diizinkan!');
        }

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus!');
    }
}