<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Gallery;
use App\Models\About; // ✅ Tambahkan ini
use App\Models\CompanyProfile; // ✅ Tambahkan ini untuk method profile
use App\Models\Team; // ✅ Tambahkan ini untuk method profile
use Illuminate\Http\Request;
use Exception;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Depan (Landing Page)
     */
    public function index()
    {
        try {
            // Ambil 3 produk terbaru saja untuk ditampilkan di Home sebagai preview
            $products = Product::latest()->take(3)->get();
            $totalProduk = Product::count();
        } catch (Exception $e) {
            $products = [];
            $totalProduk = 0;
        }

        return view('user.home', compact('products', 'totalProduk'));
    }
}
