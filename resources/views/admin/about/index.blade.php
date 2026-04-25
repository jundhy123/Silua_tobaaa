@extends('layouts.admin')
@section('page_title', 'Daftar About Us')

@section('content')
<div class="flex justify-between items-center mb-10">
    <h3 class="text-2xl font-black text-navy-dark uppercase">Konten Tentang Kami</h3>
    <a href="{{ route('admin.about.create') }}" class="btn-admin-primary">
        <i data-lucide="plus-circle"></i> Tambah Baru
    </a>
</div>

<div class="admin-card overflow-hidden">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Tahun</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($abouts as $a)
            <tr>
                <td class="w-32"><img src="{{ asset('uploads/about/'.$a->image) }}" class="w-20 h-14 object-cover rounded-lg"></td>
                <td class="font-bold">{{ $a->title }}</td>
                <td class="text-orange-brand font-bold">{{ $a->years_experience }}+</td>
                <td>
                    <div class="flex justify-center gap-3">
                        <a href="{{ route('admin.about.edit', $a->id) }}" class="action-btn-pill edit"><i data-lucide="edit-3"></i></a>
                        <form action="{{ route('admin.about.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn-pill delete"><i data-lucide="trash-2"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection