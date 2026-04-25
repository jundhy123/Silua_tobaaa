<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{
    /**
     * Menampilkan daftar semua anggota tim.
     */
    public function index() {
        $teams = Team::latest()->get();
        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Menampilkan form untuk tambah anggota baru.
     */
    public function create() {
        return view('admin.teams.create');
    }

    /**
     * Menyimpan data anggota baru ke database.
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $imageName = time().'.'.$request->photo->extension();
        $request->photo->move(public_path('uploads/teams'), $imageName);

        Team::create([
            'name' => $request->name,
            'position' => $request->position,
            'photo' => $imageName
        ]);

        return redirect()->route('admin.teams.index')->with('success', 'Anggota Tim Berhasil Ditambah!');
    }

    /**
     * Menampilkan form edit untuk anggota tertentu (Solusi Error 404/Undefined).
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        return view('admin.teams.edit', compact('team'));
    }

    /**
     * Memperbarui data anggota di database.
     */
    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048' // Nullable karena foto tidak wajib diganti
        ]);

        // Update teks
        $team->name = $request->name;
        $team->position = $request->position;

        // Cek jika ada upload foto baru
        if ($request->hasFile('photo')) {
            // 1. Hapus foto lama dari folder public/uploads/teams
            $oldFilePath = public_path('uploads/teams/' . $team->photo);
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }

            // 2. Upload foto baru
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/teams'), $imageName);
            
            // 3. Set nama foto baru ke object model
            $team->photo = $imageName;
        }

        $team->save();

        return redirect()->route('admin.teams.index')->with('success', 'Data Anggota Tim Berhasil Diperbarui!');
    }

    /**
     * Menghapus anggota dari database dan menghapus file fotonya.
     */
    public function destroy($id) {
        $team = Team::findOrFail($id);

        // Hapus file fisik sebelum hapus record database
        $filePath = public_path('uploads/teams/'.$team->photo);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $team->delete();
        return back()->with('success', 'Anggota Tim Berhasil Dihapus!');
    }
}