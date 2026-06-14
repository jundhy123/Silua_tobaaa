<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

class UserGalleryController extends Controller
{
    /**
     * Menampilkan halaman galeri visual untuk pelanggan
     */
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('user.gallery', compact('galleries'));
    }
}
