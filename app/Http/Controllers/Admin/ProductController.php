<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CompanyProfile; // 1. Pastikan Model Profile di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * 1. Menampilkan daftar semua produk
     */
    public function index()
    {
        $products = Product::with('reviews.user')->get();
        
        // 2. Ambil data profil (baris pertama)
        $profiles = CompanyProfile::first(); 

        // 3. Kirim 'profiles' ke view bersama 'products'
        return view('admin.produk.index', compact('products', 'profiles'));
    }

    /**
     * 2. Form tambah produk
     */
    public function create()
    {
        // Tambahkan juga di sini jika halaman create error yang sama
        $profiles = CompanyProfile::first();
        return view('admin.produk.create', compact('profiles'));
    }

    /**
     * 3. Simpan produk
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string'
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
        }

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'image' => $imageName,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * 4. Edit produk
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        // Tambahkan juga di sini
        $profiles = CompanyProfile::first();
        
        return view('admin.produk.edit', compact('product', 'profiles'));
    }

    /**
     * 5. Update produk
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string'
        ]);

        $data = [
            'name' => $request->name,
            'category' => $request->category,
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
     * 6. Hapus produk
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