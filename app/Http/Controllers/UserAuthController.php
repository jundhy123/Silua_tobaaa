<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Tambahkan ini untuk generate kode unik

class UserAuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLogin() {
        return view('auth.login', ['role' => 'pelanggan']);
    }

    // 2. Proses Login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials['role'] = 'pelanggan';

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['loginError' => 'Akun Pelanggan tidak ditemukan.'])->withInput();
    }

    // 3. Tampilkan Form Register
    public function showRegister() {
        return view('auth.register');
    }

    // 4. Proses Registrasi + Generate ID Pelanggan
    public function register(Request $request) {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $latestUser = User::latest('id')->first();
        $nextNumber = $latestUser ? $latestUser->id + 1 : 1;
        $customerId = 'SLT-' . date('y') . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        User::create([
            'customer_id' => $customerId,
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan',
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! ID: ' . $customerId);
    }

    // 5. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // 6. Proses Order Langsung ke WA + Simpan Database
    public function processOrder(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $totalPrice = $product->price * $request->quantity;

        // Generate Kode Order (Misal: ORD-20260408ABCD)
        $orderCode = 'ORD-' . date('Ymd') . strtoupper(Str::random(4));

        // 1. Simpan ke database agar Admin bisa konfirmasi di Dashboard
        Order::create([
            'order_code'  => $orderCode,
            'user_id'     => Auth::id(),
            'total_price' => $totalPrice,
            'status'      => 'pending' // Sesuai ENUM yang kita buat
        ]);

        // 2. Format pesan WhatsApp untuk Admin
        $adminWA = "6285361839192"; // Ganti dengan nomor WA Admin Silua Toba
        $message = "Halo Admin Silua Toba!%0A%0ASaya ingin memesan:%0A" .
                   "*Kode Order:* " . $orderCode . "%0A" .
                   "*Produk:* " . $product->name . "%0A" .
                   "*Jumlah:* " . $request->quantity . "%0A" .
                   "*Total Harga:* Rp " . number_format($totalPrice, 0, ',', '.') . "%0A" .
                   "*ID Pelanggan:* " . Auth::user()->customer_id . "%0A%0AMohon instruksi pembayarannya. Terima kasih!";

        // 3. Alihkan ke WhatsApp
        return redirect("https://wa.me/{$adminWA}?text={$message}");
    }
}
