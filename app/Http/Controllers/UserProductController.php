<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    /**
     * Menampilkan katalog produk untuk pelanggan dengan fitur filter dan pencarian
     */
    public function index(Request $request)
    {
        // Memanggil model Product beserta relasi ulasannya
        $query = Product::with(['reviews.user']);

        // Filter Pencarian berdasarkan nama produk jika ada input dari user
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori jika dipilih (kecuali 'all'/semua)
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        // Mengambil data produk dengan sistem pagination (9 produk per halaman)
        $products = $query->latest()->paginate(9)->withQueryString();

        // Mengambil daftar kategori yang tersedia untuk ditampilkan di menu filter sidebar
        Product::getAvailableCategories();
        $categories = Category::pluck('category_name')->toArray();

        return view('user.products', compact('products', 'categories'));
    }
}
