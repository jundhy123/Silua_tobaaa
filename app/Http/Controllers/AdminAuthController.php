<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin() { 
        // Mengarahkan ke view login dengan variabel role 'admin'
        return view('auth.login', ['role' => 'admin']); 
    }

    public function login(Request $request) {
        // 1. Validasi Input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // DATA ADMIN (HARDCODED UNTUK TAHAP AWAL)
        $adminEmail = 'admin@silua.com';
        $adminPass  = 'admin123';

        // 2. Cek Kredensial
        if ($request->email === $adminEmail && $request->password === $adminPass) {
            
            // 3. Pastikan user admin ada di database (Sync)
            $user = User::where('email', $adminEmail)->first();

            if (!$user) {
                $user = User::create([
                    'name'        => 'Admin Silua',
                    'first_name'  => 'Silua',
                    'last_name'   => 'Toba',
                    'email'       => $adminEmail,
                    'password'    => Hash::make($adminPass),
                    'role'        => 'admin',
                ]);
            }

            // 4. Login-kan User
            Auth::login($user, $request->remember);

            // 5. REGENERATE SESSION (PENTING: Menghindari serangan session fixation)
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        // Jika gagal
        return back()->withErrors(['loginError' => 'Akses Admin Ditolak!'])->withInput();
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('portal');
    }
}