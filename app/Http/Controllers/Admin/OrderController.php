<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {
    
    /**
     * Menampilkan daftar pesanan masuk
     */
    public function index() {
        // Ambil data order + relasi user dan items (produk)
        $orders = Order::with(['user', 'items.product'])->latest()->get();

        return view('admin.orders.index', compact('orders'));
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