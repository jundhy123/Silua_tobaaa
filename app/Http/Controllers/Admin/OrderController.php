<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {

    /**
     * Menampilkan daftar pesanan masuk dengan fitur filter status, pencarian, dan statistik ringkasan
     */
    public function index(Request $request) {
        $query = Order::with(['user', 'items.product']);

        // Fitur pencarian berdasarkan kode order, nama user, atau nama produk
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_code', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('items.product', function($qp) use ($search) {
                      $qp->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter data berdasarkan status pesanan (pending, accepted, dll)
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter data berdasarkan kategori produk yang dipesan
        if ($request->filled('category') && $request->category != 'all') {
            $query->whereHas('items.product', function($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        // Filter data berdasarkan tanggal pesanan dibuat
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Pengelompokan pesanan berdasarkan waktu (Hari ini, Kemarin, Minggu ini, Bulan ini)
        if ($request->filled('group')) {
            switch ($request->group) {
                case 'today':
                    $query->whereDate('created_at', now()->today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', now()->yesterday());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
            }
        }

        $perPage = $request->get('per_page', 10);
        $orders = $query->latest()->paginate($perPage)->withQueryString();

        // Mengambil daftar kategori unik untuk ditampilkan di filter dropdown
        $categories = \App\Models\Product::select('category')->distinct()->pluck('category');

        // Menghitung statistik untuk ditampilkan di kartu ringkasan Dashboard
        $stats = [
            'total'      => Order::count(),
            'new'        => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'accepted')->count(),
            'shipping'   => Order::where('status', 'shipping')->count(),
            'completed'  => Order::where('status', 'delivered')->count(),
            'cancelled'  => Order::where('status', 'rejected')->count(),
            'revenue'    => Order::where('status', 'delivered')->sum('total_price'),
        ];

        // Mendukung request AJAX untuk pembaruan tabel tanpa reload halaman
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.orders._table', compact('orders'))->render(),
                'stats' => view('admin.orders._stats', compact('stats'))->render(),
                'tabs'  => view('admin.orders._tabs')->render(),
            ]);
        }

        return view('admin.orders.index', compact('orders', 'stats', 'categories'));
    }

    /**
     * Memperbarui status pesanan (Terima, Tolak, Kirim, atau Selesai)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,shipping,delivered',
        ]);

        $order = Order::findOrFail($id);

        // Update status pesanan
        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status pesanan #' . $id . ' berhasil diperbarui!');
    }

    /**
     * Menghapus riwayat pesanan secara permanen (Hanya untuk pesanan yang sudah selesai atau ditolak)
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Proteksi agar pesanan yang masih aktif tidak bisa dihapus sembarangan
        if (in_array($order->status, ['pending', 'accepted', 'shipping'])) {
            return back()->with('error', 'Pesanan masih dalam proses aktif, tidak bisa dihapus!');
        }

        try {
            DB::transaction(function () use ($order) {
                // Hapus item-item di dalam pesanan terlebih dahulu sebelum menghapus data utama pesanan
                $order->items()->delete();
                $order->delete();
            });

            return back()->with('success', 'Riwayat pesanan berhasil dihapus permanen!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
