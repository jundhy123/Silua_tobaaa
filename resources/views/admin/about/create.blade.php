@extends('layouts.admin')
@section('page_title', 'Tambah Konten About')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="admin-card border-t-8 border-gray-soft">
        <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="admin-input-group">
                <label>Judul Utama</label>
                <input type="text" name="title" required class="silua-input-v2">
            </div>
            <div class="admin-input-group">
                <label>Sub Judul</label>
                <input type="text" name="subtitle" class="silua-input-v2">
            </div>
            <div class="admin-input-group">
                <label>Deskripsi Cerita</label>
                <textarea name="description" rows="5" required class="silua-input-v2"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div class="admin-input-group">
                    <label>Tahun Pengalaman</label>
                    <input type="number" name="years_experience" class="silua-input-v2">
                </div>
                <div class="admin-input-group">
                    <label>Pilih Foto</label>
                    <input type="file" name="image" required class="silua-input-v2">
                </div>
            </div>
            <button type="submit" class="btn-admin-submit-v2 w-full">SIMPAN DATA</button>
        </form>
    </div>
</div>
@endsection