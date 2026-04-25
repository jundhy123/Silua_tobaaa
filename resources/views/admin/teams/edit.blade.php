@extends('layouts.admin')

@section('title', 'Edit Anggota Tim')
@section('page_title', 'Ubah Data Tim')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Page -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-5">
            <!-- Tombol Kembali dengan Efek Hover -->
            <a href="{{ route('admin.teams.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-navy-dark shadow-sm hover:bg-gray-soft hover:text-white hover:rotate-[-10deg] transition-all duration-300">
                <i data-lucide="chevron-left" class="w-6 h-6"></i>
            </a>
            <div>
                <h3 class="text-2xl font-black text-navy-dark tracking-tight uppercase">Edit Anggota Tim</h3>
                <p class="text-gray-400 text-sm font-medium">Perbarui profil pemilik atau staff Silua Toba.</p>
            </div>
        </div>
    </div>

    <!-- Main Card Form -->
    <div class="admin-card border-t-[10px] border-gray-soft shadow-2xl relative overflow-hidden">
        <!-- Dekorasi Background Halus (Warna Kuning Aksen) -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-bg-light/10 rounded-full -mr-16 -mt-16"></div>

        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8 relative z-10">
            @csrf
            @method('PUT') <!-- Wajib ada untuk proses update -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                <!-- Nama Lengkap -->
                <div class="admin-input-group">
                    <label class="form-label-custom">Nama Lengkap</label>
                    <div class="relative">
                        <i data-lucide="user" class="input-icon-left"></i>
                        <input type="text" name="name" value="{{ old('name', $team->name) }}" required class="silua-input-v2" placeholder="Nama lengkap anggota">
                    </div>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Jabatan -->
                <div class="admin-input-group">
                    <label class="form-label-custom">Jabatan / Posisi</label>
                    <div class="relative">
                        <i data-lucide="briefcase" class="input-icon-left"></i>
                        <input type="text" name="name" name="position" value="{{ old('position', $team->position) }}" required class="silua-input-v2" placeholder="Contoh: Owner / Manager">
                    </div>
                    @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Bagian Foto Profil -->
            <div class="admin-input-group">
                <label class="form-label-custom">Foto Profil</label>
                <div class="flex flex-col md:flex-row items-center gap-8 p-6 bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-soft/30">
                    <!-- Preview Foto Lama -->
                    <div class="text-center">
                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-2">Foto Saat Ini</p>
                        <img src="{{ asset('uploads/teams/'.$team->photo) }}" class="w-32 h-32 object-cover rounded-2xl border-4 border-white shadow-lg">
                    </div>

                    <div class="flex-1 w-full">
                        <p class="text-xs font-bold text-navy-dark mb-3 uppercase opacity-60">Ganti Foto Baru</p>
                        <div class="relative group">
                            <input type="file" name="photo" id="photo" class="hidden-file-input" onchange="updateFileName(this)">
                            <label for="photo" class="file-upload-wrapper !bg-white">
                                <i data-lucide="image" class="w-5 h-5 text-gray-soft"></i>
                                <span id="file-chosen" class="text-gray-400 font-medium">Pilih file jika ingin ganti...</span>
                                <span class="bg-navy-dark text-white px-3 py-1 rounded-lg text-[10px] ml-auto uppercase font-bold">Browse</span>
                            </label>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-3 italic">*Abaikan jika tidak ingin mengubah foto.</p>
                    </div>
                </div>
                @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.teams.index') }}" class="px-8 py-4 text-gray-400 font-bold hover:text-navy-dark transition-all uppercase text-xs tracking-widest">
                    Batal
                </a>
                <button type="submit" class="btn-admin-submit-v2 shadow-navy-dark/20 shadow-2xl">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    <span>UPDATE DATA TIM</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Script untuk update nama file saat dipilih
    function updateFileName(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            document.getElementById('file-chosen').textContent = fileName;
            document.getElementById('file-chosen').classList.add('text-navy-dark');
        }
    }
</script>
@endsection