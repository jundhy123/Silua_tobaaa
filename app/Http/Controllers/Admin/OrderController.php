<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {
    
    public function index() {
        // Ambil data order + relasi
        $orders = Order::with(['user','items.product'])->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,rejected'
        ]);

        $order = Order::findOrFail($id);

        // Update status
        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    // 🔥 FITUR HAPUS PESANAN
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // ❗ tidak boleh hapus kalau masih pending
        if ($order->status == 'pending') {
            return back()->with('error', 'Pesanan masih pending, tidak bisa dihapus!');
        }

        // Hapus semua item dulu
        if ($order->items) {
            $order->items()->delete();
        }

        // Hapus order
        $order->delete();

        return back()->with('success', 'Pesanan berhasil dihapus!');
    }
}