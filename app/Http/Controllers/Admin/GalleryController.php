<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    /**
     * Menampilkan daftar foto galeri di halaman Admin.
     */
    public function index() {
        $galleries = Gallery::latest()->paginate(10);
        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Menampilkan form tambah foto.
     */
    public function create() {
        return view('admin.gallery.create');
    }

    /**
     * Menyimpan foto baru ke database dan folder upload.
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'file'  => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // Proses Upload File
        $fileName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads/gallery'), $fileName);

        // Simpan ke Database
        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'file'  => $fileName,
            'type'  => 'image'
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil ditambahkan ke galeri!');
    }

    /**
     * ✅ FUNGSI EDIT (MENAMPILKAN FORM UBAH)
     */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * ✅ FUNGSI UPDATE (MENYIMPAN PERUBAHAN)
     */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'file'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Nullable karena foto tidak wajib diganti
        ]);

        // Data teks yang akan diupdate
        $gallery->title = $request->title;
        $gallery->description = $request->description;

        // Logika Ganti Foto
        if ($request->hasFile('file')) {
            // 1. Hapus foto lama dari server
            $oldPath = public_path('uploads/gallery/' . $gallery->file);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }

            // 2. Upload foto baru
            $fileName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('uploads/gallery'), $fileName);

            // 3. Masukkan nama file baru ke model
            $gallery->file = $fileName;
        }

        $gallery->save();

        return redirect()->route('admin.gallery.index')->with('success', 'Dokumentasi berhasil diperbarui!');
    }

    /**
     * Menghapus foto dari database dan file fisiknya.
     */
    public function destroy($id) {
        $item = Gallery::findOrFail($id);

        $filePath = public_path('uploads/gallery/' . $item->file);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $item->delete();

        return back()->with('success', 'Foto berhasil dihapus dari galeri');
    }
}
