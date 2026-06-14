<?php

namespace App\Http\Controllers;

use App\Models\About;

class UserAboutController extends Controller
{
    /**
     * Menampilkan halaman kisah brand/sejarah untuk pelanggan
     */
    public function index()
    {
        $abouts = About::orderBy('id', 'asc')->get();
        return view('user.about', compact('abouts'));
    }
}
