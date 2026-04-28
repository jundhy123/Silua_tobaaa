<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    private const UPLOAD_PATH = 'uploads/about';

    /**
     * Validasi rules untuk about content
     */
    protected function validationRules($isUpdate = false): array
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'years_experience' => 'nullable|integer|min:0',
            'image' => ($isUpdate ? 'nullable' : 'required') . '|image|mimes:jpg,png,jpeg,webp|max:2048'
        ];
    }

    // Menampilkan Daftar Semua Konten About (READ)
    public function index()
    {
        $abouts = About::latest()->paginate(10);
        return view('admin.about.index', compact('abouts'));
    }

    // Menampilkan Form Tambah (CREATE)
    public function create()
    {
        return view('admin.about.create');
    }

    // Menyimpan Data Baru (STORE)
    public function store(Request $request)
    {
        $data = $request->validate($this->validationRules());

        if ($request->hasFile('image')) {
            $fileName = $this->storeImage($request->file('image'));
            $data['image'] = $fileName;
        }

        About::create($data);
        return redirect()->route('admin.about.index')->with('success', 'Konten About berhasil ditambahkan!');
    }

    // Menampilkan Form Edit Berdasarkan ID
    public function edit(About $about)
    {
        return view('admin.about.edit', compact('about'));
    }

    // Mengupdate Data (UPDATE)
    public function update(Request $request, About $about)
    {
        $data = $request->validate($this->validationRules(true));

        if ($request->hasFile('image')) {
            // Hapus foto lama terlebih dahulu
            $this->deleteImage($about->image);
            
            // Simpan foto baru
            $fileName = $this->storeImage($request->file('image'));
            $data['image'] = $fileName;
        }

        $about->update($data);
        return redirect()->route('admin.about.index')->with('success', 'Konten About berhasil diperbarui!');
    }

    // Menghapus Data (DELETE)
    public function destroy(About $about)
    {
        $this->deleteImage($about->image);
        $about->delete();
        return back()->with('success', 'Konten About berhasil dihapus!');
    }

    /**
     * Upload dan simpan image
     */
    private function storeImage($image): string
    {
        $uploadDir = public_path(self::UPLOAD_PATH);
        
        // Pastikan folder exist
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        $fileName = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) 
                    . '_' . Str::random(8) 
                    . '.' . $image->extension();
        
        $image->move($uploadDir, $fileName);
        
        return $fileName;
    }

    /**
     * Hapus image dari storage
     */
    private function deleteImage(?string $fileName): void
    {
        if (!$fileName) {
            return;
        }

        $filePath = public_path(self::UPLOAD_PATH . '/' . $fileName);
        
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }
}