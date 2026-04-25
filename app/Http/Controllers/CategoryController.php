<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // 🔹 Tampilkan semua data
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // 🔹 Form tambah data
    public function create()
    {
        return view('categories.create');
    }

    // 🔹 Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:100'
        ]);

        Category::create([
            'category_name' => $request->category_name
        ]);

        return redirect()->route('categories.index')
                         ->with('success', 'Data berhasil ditambahkan');
    }

    // 🔹 Form edit
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // 🔹 Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|max:100'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'category_name' => $request->category_name
        ]);

        return redirect()->route('categories.index')
                         ->with('success', 'Data berhasil diupdate');
    }

    // 🔹 Hapus data
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Data berhasil dihapus');
    }
}