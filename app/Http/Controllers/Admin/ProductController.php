<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk untuk dikelola Admin
     */
    public function index()
    {
        $products = Product::with('reviews.user')->latest()->paginate(10);
        $profiles = CompanyProfile::first();
        return view('admin.produk.index', compact('products', 'profiles'));
    }

    /**
     * Membuka halaman formulir untuk menambah produk baru
     */
    public function create()
    {
        $profiles = CompanyProfile::first();
        $categories = Product::getAvailableCategories();
        return view('admin.produk.create', compact('profiles', 'categories'));
    }

    /**
     * Memproses penyimpanan data produk baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input: Nama wajib, Kategori wajib, Harga minimal 0, Gambar wajib
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
        }

        $cat = \App\Models\Category::where('category_name', $request->category)->first();

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'category_id' => $cat->category_id ?? null,
            'price' => $request->price,
            'image' => $imageName,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Membuka halaman edit untuk mengubah data produk yang sudah ada
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $profiles = CompanyProfile::first();
        $categories = Product::getAvailableCategories();

        return view('admin.produk.edit', compact('product', 'profiles', 'categories'));
    }

    /**
     * Memproses pembaruan data produk ke database
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string'
        ]);

        $cat = \App\Models\Category::where('category_name', $request->category)->first();

        $data = [
            'name' => $request->name,
            'category' => $request->category,
            'category_id' => $cat->category_id ?? null,
            'price' => $request->price,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $oldImagePath = public_path('uploads/products/' . $product->image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk secara permanen beserta file gambarnya
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $imagePath = public_path('uploads/products/' . $product->image);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $product->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
