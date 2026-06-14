@extends('layouts.admin')

@section('title', 'Ubah Info Tim - Admin Silua Toba')
@section('page_title', 'Update Tim')

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
    .avatar-upload {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: #f8fafc;
        border: 3px dashed #e2e8f0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        margin: 0 auto;
    }
    .avatar-upload:hover {
        border-color: var(--primary-orange);
    }
    .current-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        margin: 0 auto;
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
            <h1 class="text-4xl font-black italic text-gray-900" style="font-family: 'Playfair Display', serif;">Ubah <span class="text-primary-orange">Info Anggota</span></h1>
            <p class="text-gray-400 text-sm mt-1 italic">Perbarui kredensial dan identitas visual <b>{{ $team->name }}</b>.</p>
        </div>
        <a href="{{ route('admin.teams.index') }}" class="px-6 py-3 bg-white border border-gray-100 text-gray-400 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-gray-900 hover:text-white transition-all shadow-sm flex items-center gap-2">
            <i data-lucide="x" class="w-4 h-4"></i>
            Batalkan
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="form-card shadow-sm">
        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data" class="space-y-12">
            @csrf
            @method('PUT')

            <!-- PHOTO UPDATE -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center max-w-lg mx-auto">
                    <div class="space-y-3">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block text-center">Foto Saat Ini</span>
                        <div class="current-avatar">
                            <img src="{{ asset('uploads/teams/'.$team->photo) }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="space-y-3">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block text-center">Ganti Foto</span>
                        <div class="avatar-upload group" onclick="document.getElementById('photoInput').click()">
                            <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden">
                            <div id="placeholder" class="flex flex-col items-center gap-3 text-gray-300">
                                <i data-lucide="refresh-cw" class="w-6 h-6 group-hover:text-primary-orange transition-colors"></i>
                            </div>
                            <input type="file" name="photo" id="photoInput" accept="image/*" onchange="previewImage(event)" class="hidden">
                        </div>
                    </div>
                </div>
                <p class="text-[9px] text-gray-400 italic text-center uppercase tracking-widest mt-6">Biarkan kosong untuk mempertahankan foto lama</p>
                @error('photo') <p class="text-red-500 text-[10px] font-bold text-center mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $team->name) }}" required class="form-input font-bold italic text-lg">
                </div>

                <div class="space-y-2">
                    <label class="form-label">Posisi / Jabatan</label>
                    <input type="text" name="position" value="{{ old('position', $team->position) }}" required class="form-input font-bold">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-save">
                    Simpan Perubahan
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
