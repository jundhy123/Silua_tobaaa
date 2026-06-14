<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Team;

class UserProfileController extends Controller
{
    /**
     * Menampilkan halaman profil bisnis dan tim untuk pelanggan
     */
    public function index()
    {
        $info = CompanyProfile::first();
        $teams = Team::all();
        return view('user.profile', compact('info', 'teams'));
    }
}
