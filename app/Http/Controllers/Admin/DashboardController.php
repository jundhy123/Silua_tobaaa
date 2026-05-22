<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // WAJIB ADA INI
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Statistik Dasar
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalWorkers = Team::count();
        $totalCustomers = User::where('role', 'pelanggan')->count();

        // 2. LOGIKA PENDAPATAN BULAN INI (Status 'delivered' / Selesai)
        $monthlyRevenue = Order::where('status', 'delivered')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->sum('total_price');

        // 3. LOGIKA PRODUK TERLARIS BULAN INI
        $soldProducts = OrderItem::whereHas('order', function($query) {
                $query->where('status', 'delivered')
                      ->whereMonth('updated_at', Carbon::now()->month)
                      ->whereYear('updated_at', Carbon::now()->year);
            })
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->with('product')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        // 4. DATA UNTUK GRAFIK (7 Hari Terakhir)
        $dates = [];
        $userRegistrationData = [];
        $orderData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = Carbon::now()->subDays($i)->translatedFormat('d M');
            
            $userRegistrationData[] = User::where('role', 'pelanggan')
                ->whereDate('created_at', $date)->count();
                
            $orderData[] = Order::whereDate('created_at', $date)->count();
        }

        // 5. KIRIM SEMUA VARIABEL KE VIEW
        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalOrders', 
            'totalWorkers', 
            'totalCustomers',
            'monthlyRevenue', // Variabel yang tadi error
            'soldProducts',   // Data produk terlaris
            'dates', 
            'userRegistrationData', 
            'orderData'
        ));
    }
}