@extends('layouts.admin')

@section('title', 'Ubah Momen - Admin Silua Toba')
@section('page_title', 'Update Visual')

@section('content')
<style>
    :root { --primary-orange: #FF5722; }
    .form-card {
        background: white;
        border-radius: 3.5rem;
        padding: 4rem;
        border: 1px solid #f1f5f9;
    }
    .form-label {
        display: block;
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: #94a3b8;
        margin-bottom: 1rem;
    }
    .form-input {
        width: 100%;
        padding: 1.25rem 1.5rem;
        background: #f8fafc;
        border: 2px solid transparent;
        border-radius: 1.25rem;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.3s ease;
    }
    .form-input:focus {
        background: white;
        border-color: var(--primary-orange);
        outline: none;
        box-shadow: 0 10px 25px -5px rgba(255, 87, 34, 0.1);
    }
    .image-preview-box {
        width: 100%;
        height: 250px;
        background: #f8fafc;
        border-radius: 2rem;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        position: relative;
    }
    .image-upload-box {
        width: 100%;
        height: 250px;
        background: #f8fafc;
        border: 3px dashed #e2e8f0;
        border-radius: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }
    .image-upload-box:hover {
        border-color: var(--primary-orange);
        background: white;
    }
    .btn-save {
        background: #111;
        color: white;
        padding: 1.25rem 2.5rem;
        border-radius: 1.25rem;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        transition: all 0.3s ease;
        width: 100%;
    }
    .btn-save:hover {
        background: var(--primary-orange);
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(255, 87, 34, 0.2);
    }
</style>

<div class="max-w-4xl mx-auto space-y-10 animate-fade-in">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-4xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Ubah <span class="text-primary-orange">Momen</span></h1>
            <p class="text-gray-400 text-sm mt-1 italic">Perbarui detail arsip visual <b>{{ $gallery->title }}</b>.</p>
        </div>
        <a href="{{ route('admin.gallery.index') }}" class="px-6 py-3 bg-white border border-gray-100 text-gray-400 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-gray-900 hover:text-white transition-all shadow-sm flex items-center gap-2">
            <i data-lucide="x" class="w-4 h-4"></i>
            Batalkan
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="form-card shadow-sm">
        <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label class="form-label">Judul Momen</label>
                <input type="text" name="title" value="{{ old('title', $gallery->title) }}" required class="form-input font-bold italic text-lg">
            </div>

            <div class="space-y-2">
                <label class="form-label">Narasi Arsip</label>
                <textarea name="description" rows="4" class="form-input resize-none leading-relaxed">{{ old('description', $gallery->description) }}</textarea>
            </div>

            <div class="space-y-4">
                <label class="form-label">Update Visual</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block text-center">Visual Saat Ini</span>
                        <div class="image-preview-box">
                            <img src="{{ asset('uploads/gallery/'.$gallery->file) }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="space-y-3">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block text-center">Ganti Gambar</span>
                        <div class="image-upload-box group" onclick="document.getElementById('fileInput').click()">
                            <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden">
                            <div id="placeholder" class="flex flex-col items-center gap-3 text-gray-300">
                                <i data-lucide="refresh-cw" class="w-8 h-8 group-hover:text-primary-orange transition-colors"></i>
                                <span class="text-[9px] font-black uppercase tracking-widest">Klik untuk Upload</span>
                            </div>
                            <input type="file" name="file" id="fileInput" accept="image/*" onchange="previewImage(event)" class="hidden">
                        </div>
                    </div>
                </div>
                <p class="text-[9px] text-gray-400 italic text-center uppercase tracking-widest mt-4">Biarkan kosong jika tidak ingin mengubah gambar</p>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-save">
                    Konfirmasi Pembaruan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        var output = document.getElementById('preview');
        var placeholder = document.getElementById('placeholder');
        reader.onload = function(){
            output.src = reader.result;
            output.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
