<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    /**
     * Menampilkan katalog produk untuk sisi pelanggan (User)
     */
    public function index(Request $request)
    {
        $query = Product::with(['reviews.user']);

        // Filter Pencarian Nama
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Filter Kategori
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        // Ambil produk dengan pagination (9 per halaman)
        $products = $query->latest()->paginate(9)->withQueryString();

        // Ambil daftar kategori dari model Product (Hardcoded list)
        $categories = Product::getAvailableCategories();

        return view('user.products', compact('products', 'categories'));
    }
}
