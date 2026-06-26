<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Gallery;
use App\Models\About;
use App\Models\CompanyProfile;
use App\Models\Team;
use Illuminate\Http\Request;
use Exception;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Depan (Landing Page) untuk pelanggan
     */
    public function index()
    {
        try {
            // Mengambil 3 produk terbaru saja untuk ditampilkan di Home sebagai preview koleksi
            $products = Product::latest()->take(3)->get();

            // Menghitung total seluruh produk untuk statistik "Resep Warisan" di Landing Page
            $totalProduk = Product::count();
        } catch (Exception $e) {
            $products = [];
            $totalProduk = 0;
        }

        // Mengirimkan data produk dan total produk ke view home
        return view('user.home', compact('products', 'totalProduk'));
    }
}
