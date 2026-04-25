<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function index()
    {
        $profiles = CompanyProfile::latest()->get();
        return view('admin.profile.index', compact('profiles'));
    }

    public function create()
    {
        return view('admin.profile.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hero_title'   => 'required|string|max:255',
            'history_text' => 'required',
            'vision'       => 'required',
            'mission'      => 'required',
            'map_embed'    => 'required',
        ]);

        CompanyProfile::create($data);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profil berhasil ditambahkan');
    }

    public function edit($id)
    {
        $profile = CompanyProfile::findOrFail($id);
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $profile = CompanyProfile::findOrFail($id);

        $data = $request->validate([
            'hero_title'   => 'required|string|max:255',
            'history_text' => 'required',
            'vision'       => 'required',
            'mission'      => 'required',
            'map_embed'    => 'required',
        ]);

        $profile->update($data);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profil berhasil diupdate');
    }

    public function destroy($id)
    {
        CompanyProfile::destroy($id);

        return back()->with('success', 'Profil berhasil dihapus');
    }
}