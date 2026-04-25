<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Team;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Total
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalWorkers = Team::count();
        $totalCustomers = User::where('role', 'pelanggan')->count();

        // 2. Siapkan data grafik (7 hari terakhir)
        $dates = [];
        $userRegistrationData = []; 
        $orderData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dates[] = $date->format('D, d M');
            
            // Hitung pendaftaran per hari
            $userRegistrationData[] = User::where('role', 'pelanggan')
                                      ->whereDate('created_at', $date->format('Y-m-d'))
                                      ->count();
                                      
            // Hitung pesanan per hari                          
            $orderData[] = Order::whereDate('created_at', $date->format('Y-m-d'))
                                ->count();
        }

        // 3. Kirim ke View dengan nama variabel yang konsisten
        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalOrders', 
            'totalWorkers', 
            'totalCustomers',
            'dates',
            'userRegistrationData', // Nama ini harus ada di sini
            'orderData'
        ));
    }
}