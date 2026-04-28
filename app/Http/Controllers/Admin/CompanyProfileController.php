<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    /**
     * Validasi rules untuk company profile
     */
    protected function validationRules(): array
    {
        return [
            'hero_title'   => 'required|string|max:255',
            'history_text' => 'required|string',
            'vision'       => 'required|string',
            'mission'      => 'required|string',
            'map_embed'    => 'required|string', // Pastikan tidak mengandung JS berbahaya
        ];
    }

    public function index()
    {
        $profiles = CompanyProfile::latest()->paginate(10);
        return view('admin.profile.index', compact('profiles'));
    }

    public function create()
    {
        return view('admin.profile.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->validationRules());

        // Sanitize map_embed jika berisi HTML
        $data['map_embed'] = strip_tags($data['map_embed'], '<iframe>');

        CompanyProfile::create($data);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profil berhasil ditambahkan');
    }

    public function edit(CompanyProfile $profile)
    {
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request, CompanyProfile $profile)
    {
        $data = $request->validate($this->validationRules());

        // Sanitize map_embed jika berisi HTML
        $data['map_embed'] = strip_tags($data['map_embed'], '<iframe>');

        $profile->update($data);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profil berhasil diupdate');
    }

    public function destroy(CompanyProfile $profile)
    {
        $profile->delete();

        return back()->with('success', 'Profil berhasil dihapus');
    }
}