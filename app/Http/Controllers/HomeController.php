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
    public function index()
    {
        try {
            $categories = Category::all();
            $products = Product::all();
        } catch (Exception $e) {
            $categories = [];
            $products = [];
        }

        return view('user.home', compact('categories', 'products'));
    }

    /**
     * HALAMAN GALERI
     */
    public function gallery()
    {
        try {
            $galleries = Gallery::latest()->get();
        } catch (Exception $e) {
            $galleries = [];
        }

        return view('user.gallery', compact('galleries'));
    }

    /**
     * HALAMAN PROFIL
     */
    public function profile() 
    {
        try {
            $info = CompanyProfile::first(); // Ambil satu data profil
            $teams = Team::all(); // Ambil semua tim
        } catch (Exception $e) {
            $info = null;
            $teams = [];
        }

        return view('user.profile', compact('info', 'teams'));
    }

    /**
     * HALAMAN ABOUT US (SOLUSI ERROR ANDA)
     */
    public function about()
    {
        try {
            // Mengambil data About pertama dari database
            $abouts = \App\Models\About::orderBy('id', 'asc')->get();

        } catch (Exception $e) {
            $about = null;
        }

        // Mengarahkan ke file resources/views/user/about.blade.php
        return view('user.about', compact('abouts'));
    }
}