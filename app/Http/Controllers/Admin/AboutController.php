<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    // Menampilkan Daftar Semua Konten About (READ)
    public function index() {
        $abouts = About::latest()->get();
        return view('admin.about.index', compact('abouts'));
    }

    // Menampilkan Form Tambah (CREATE)
    public function create() {
        return view('admin.about.create');
    }

    // Menyimpan Data Baru (STORE)
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        $fileName = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads/about'), $fileName);

        About::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'years_experience' => $request->years_experience,
            'image' => $fileName
        ]);

        return redirect()->route('admin.about.index')->with('success', 'Konten About berhasil ditambahkan!');
    }

    // Menampilkan Form Edit Berdasarkan ID
    public function edit($id) {
        $about = About::findOrFail($id); // Mencari data berdasarkan ID
        return view('admin.about.edit', compact('about'));
    }

    // Mengupdate Data (UPDATE)
    public function update(Request $request, $id) {
        $about = About::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus foto lama agar tidak menumpuk di folder
            if ($about->image && File::exists(public_path('uploads/about/'.$about->image))) {
                File::delete(public_path('uploads/about/'.$about->image));
            }
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/about'), $fileName);
            $data['image'] = $fileName;
        }

        $about->update($data);
        return redirect()->route('admin.about.index')->with('success', 'Konten About berhasil diperbarui!');
    }

    // Menghapus Data (DELETE)
    public function destroy($id) {
        $about = About::findOrFail($id);
        if ($about->image && File::exists(public_path('uploads/about/'.$about->image))) {
            File::delete(public_path('uploads/about/'.$about->image));
        }
        $about->delete();
        return back()->with('success', 'Konten About berhasil dihapus!');
    }
}