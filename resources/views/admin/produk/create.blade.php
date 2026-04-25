@extends('layouts.admin')
@section('page_title', 'Tambah Profil')

@section('content')
<div class="max-w-4xl">

    <form action="{{ route('admin.profile.store') }}" method="POST">
        @csrf

        <div class="admin-input-group">
            <label>Hero Title</label>
            <input type="text" name="hero_title" class="silua-input-v2" required>
        </div>

        <div class="admin-input-group">
            <label>History</label>
            <textarea name="history_text" class="silua-input-v2" required></textarea>
        </div>

        <div class="admin-input-group">
            <label>Vision</label>
            <textarea name="vision" class="silua-input-v2" required></textarea>
        </div>

        <div class="admin-input-group">
            <label>Mission</label>
            <textarea name="mission" class="silua-input-v2" required></textarea>
        </div>

        <div class="admin-input-group">
            <label>Map Embed</label>
            <input type="text" name="map_embed" class="silua-input-v2" required>
        </div>

        <button type="submit" class="btn-admin-submit-v2 mt-4 w-full">
            SIMPAN
        </button>
    </form>

</div>
@endsection