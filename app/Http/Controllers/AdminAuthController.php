<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin() { 
        return view('auth.login', ['role' => 'admin']); 
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // =========================================================
        // SETTING DATA ADMIN LANGSUNG DI KODINGAN
        // =========================================================
        $adminEmail = 'admin@silua.com'; // Ganti dengan email admin mau Anda
        $adminPass  = 'admin123';        // Ganti dengan password admin mau Anda
        // =========================================================

        // 1. Cek apakah yang diinput user sama dengan data di atas
        if ($request->email === $adminEmail && $request->password === $adminPass) {
            
            // 2. Cari user di database, jika belum ada (karena baru/database kosong), buatkan otomatis
            $user = User::where('email', $adminEmail)->first();

            if (!$user) {
                $user = User::create([
                    'admin_id' => 'ADM-001',
                    'name'        => 'Super Admin Silua',
                    'first_name'  => 'Super',
                    'last_name'   => 'Admin',
                    'email'       => $adminEmail,
                    'password'    => Hash::make($adminPass),
                    'role'        => 'admin',
                ]);
            }

            // 3. Login-kan user tersebut ke dalam sistem
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();

            return redirect()->intended('/admin/dashboard');
        }

        // Jika input tidak cocok dengan data admin di kodingan tadi
        return back()->withErrors(['loginError' => 'Akses Admin Ditolak! Data tidak cocok.'])->withInput();
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('portal');
    }
}