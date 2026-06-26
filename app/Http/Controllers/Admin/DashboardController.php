<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'monthly');

        // 1. RINGKASAN PENJUALAN (TOTALS & GROWTH)
        $stats = $this->getGeneralStats();

        // 2. DATA GRAFIK
        $chartData = $this->getChartData($period);

        // 3. DISTRIBUSI KATEGORI (Hanya status Selesai)
        $categoryDist = $this->getCategoryDistribution();

        // 4. PRODUK TERLARIS (Hanya status Selesai)
        $topProducts = $this->getTopProducts();

        // 5. INSIGHTS
        $insights = $this->getInsights($stats, $categoryDist, $topProducts);

        // 6. STATS DASAR TAMBAHAN
        $totalCustomers = User::where('role', 'pelanggan')->count();
        $totalProducts = Product::count();

        return view('admin.dashboard', compact(
            'stats',
            'chartData',
            'categoryDist',
            'topProducts',
            'insights',
            'period',
            'totalCustomers',
            'totalProducts'
        ));
    }

    private function getGeneralStats()
    {
        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // Current Month Stats (Selesai)
        $currentRevenue = Order::where('status', 'delivered')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('total_price');

        $currentOrders = Order::where('status', 'delivered')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $currentItems = OrderItem::whereHas('order', function($q) use ($now) {
                $q->where('status', 'delivered')
                  ->whereMonth('created_at', $now->month)
                  ->whereYear('created_at', $now->year);
            })->sum('quantity');

        // Last Month Stats for Comparison
        $prevRevenue = Order::where('status', 'delivered')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total_price');

        $prevOrders = Order::where('status', 'delivered')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $prevItems = OrderItem::whereHas('order', function($q) use ($lastMonth) {
                $q->where('status', 'delivered')
                  ->whereMonth('created_at', $lastMonth->month)
                  ->whereYear('created_at', $lastMonth->year);
            })->sum('quantity');

        return [
            'revenue' => [
                'total' => Order::where('status', 'delivered')->sum('total_price'),
                'current_month' => $currentRevenue,
                'diff' => $this->calculateDiff($currentRevenue, $prevRevenue)
            ],
            'orders' => [
                'total' => Order::where('status', 'delivered')->count(),
                'current_month' => $currentOrders,
                'diff' => $this->calculateDiff($currentOrders, $prevOrders)
            ],
            'items' => [
                'total' => OrderItem::whereHas('order', function($q){ $q->where('status', 'delivered'); })->sum('quantity'),
                'current_month' => $currentItems,
                'diff' => $this->calculateDiff($currentItems, $prevItems)
            ]
        ];
    }

    private function calculateDiff($current, $prev)
    {
        if ($prev == 0) return $current > 0 ? 100 : 0;
        return (($current - $prev) / $prev) * 100;
    }

    private function getChartData($period)
    {
        $labels = [];
        $revenue = [];
        $orders = [];

        if ($period == 'daily') {
            $days = 7;
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $labels[] = $date->translatedFormat('d M');
                $dayData = Order::where('status', 'delivered')->whereDate('created_at', $date);
                $revenue[] = (float)$dayData->sum('total_price');
                $orders[] = $dayData->count();
            }
        } elseif ($period == 'weekly') {
            $weeks = 4;
            for ($i = $weeks - 1; $i >= 0; $i--) {
                $start = Carbon::now()->subWeeks($i)->startOfWeek();
                $end = Carbon::now()->subWeeks($i)->endOfWeek();
                $labels[] = 'Mg ' . ($weeks - $i);
                $weekData = Order::where('status', 'delivered')->whereBetween('created_at', [$start, $end]);
                $revenue[] = (float)$weekData->sum('total_price');
                $orders[] = $weekData->count();
            }
        } elseif ($period == 'yearly') {
            $years = 5;
            for ($i = $years - 1; $i >= 0; $i--) {
                $year = Carbon::now()->subYears($i)->year;
                $labels[] = $year;
                $yearData = Order::where('status', 'delivered')->whereYear('created_at', $year);
                $revenue[] = (float)$yearData->sum('total_price');
                $orders[] = $yearData->count();
            }
        } else { // monthly
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $labels[] = $date->translatedFormat('M y');
                $monthData = Order::where('status', 'delivered')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year);
                $revenue[] = (float)$monthData->sum('total_price');
                $orders[] = $monthData->count();
            }
        }

        return ['labels' => $labels, 'revenue' => $revenue, 'orders' => $orders];
    }

    private function getCategoryDistribution()
    {
        $categories = ['Minuman', 'cemilan', 'Makanan Berat'];
        $dist = [];
        $totalSold = OrderItem::whereHas('order', function($q){ $q->where('status', 'delivered'); })->sum('quantity');

        foreach ($categories as $cat) {
            $count = OrderItem::whereHas('order', function($q){ $q->where('status', 'delivered'); })
                ->whereHas('product', function($q) use ($cat){ $q->where('category', $cat); })
                ->sum('quantity');

            $dist[] = [
                'name' => $cat,
                'count' => $count,
                'percentage' => $totalSold > 0 ? round(($count / $totalSold) * 100, 1) : 0
            ];
        }
        return ['total' => $totalSold, 'data' => $dist];
    }

    private function getTopProducts()
    {
        $totalSold = OrderItem::whereHas('order', function($q){ $q->where('status', 'delivered'); })->sum('quantity');

        return OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('order', function($q){ $q->where('status', 'delivered'); })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get()
            ->map(function($item) use ($totalSold) {
                $item->percentage = $totalSold > 0 ? round(($item->total_qty / $totalSold) * 100, 1) : 0;
                return $item;
            });
    }

    private function getInsights($stats, $categoryDist, $topProducts)
    {
        $topCat = collect($categoryDist['data'])->sortByDesc('count')->first();
        $topProd = $topProducts->first();
        $revenueDiff = $stats['revenue']['diff'];

        $comparisonText = $revenueDiff >= 0
            ? "naik " . round($revenueDiff, 1) . "% dibanding bulan lalu."
            : "turun " . abs(round($revenueDiff, 1)) . "% dibanding bulan lalu.";

        return [
            'top_category' => $topCat ? $topCat['name'] : '-',
            'top_product' => $topProd ? $topProd->product->name : '-',
            'total_sold' => $categoryDist['total'],
            'comparison' => "Pendapatan bulan ini " . $comparisonText
        ];
    }
}
