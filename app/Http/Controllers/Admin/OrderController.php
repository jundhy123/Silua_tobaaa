<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {

    /**
     * Menampilkan daftar pesanan masuk dengan filter, pencarian, dan statistik
     */
    public function index(Request $request) {
        $query = Order::with(['user', 'items.product']);

        // 1. PENCARIAN CEPAT
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

        // 2. FILTER STATUS
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // 3. FILTER TANGGAL (Hanya tanggal tertentu)
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // 7. PENGELOMPOKAN PESANAN (TABS)
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

        // STATISTIK RINGKASAN
        $stats = [
            'total'      => Order::count(),
            'new'        => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'accepted')->count(),
            'shipping'   => Order::where('status', 'shipping')->count(),
            'completed'  => Order::where('status', 'delivered')->count(),
            'cancelled'  => Order::where('status', 'rejected')->count(),
            'revenue'    => Order::where('status', 'delivered')->sum('total_price'),
        ];

        // CEK APAKAH REQUEST AJAX
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.orders._table', compact('orders'))->render(),
                'stats' => view('admin.orders._stats', compact('stats'))->render(),
                'tabs'  => view('admin.orders._tabs')->render(),
            ]);
        }

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Update Status Pesanan (Accepted, Rejected, Shipping, Delivered)
     */
    public function updateStatus(Request $request, $id)
    {
        // Validasi status sesuai alur premium
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,shipping,delivered',
            'reject_reason' => 'nullable|string'
        ]);

        $order = Order::findOrFail($id);

        // Update status dan simpan alasan penolakan (jika ada)
        $order->update([
            'status' => $request->status,
            'reject_reason' => $request->status == 'rejected' ? $request->reject_reason : null
        ]);

        return back()->with('success', 'Status pesanan #' . $id . ' berhasil diperbarui!');
    }

    /**
     * Hapus Riwayat Pesanan
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Proteksi: Hanya boleh hapus jika sudah selesai (delivered) atau ditolak (rejected)
        // Pesanan yang masih diproses (pending, accepted, shipping) tidak boleh dihapus
        if (in_array($order->status, ['pending', 'accepted', 'shipping'])) {
            return back()->with('error', 'Pesanan masih dalam proses aktif, tidak bisa dihapus!');
        }

        try {
            DB::transaction(function () use ($order) {
                // Hapus semua detail item terkait (OrderItem) agar tidak jadi sampah di DB
                $order->items()->delete();

                // Hapus data order utama
                $order->delete();
            });

            return back()->with('success', 'Riwayat pesanan berhasil dihapus permanen!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
