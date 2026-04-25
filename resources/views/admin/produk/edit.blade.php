@extends('layouts.admin')
@section('page_title', 'Edit Profil')

@section('content')
<div class="max-w-5xl">

    @if(session('success'))
        <p class="text-green-600">{{ session('success') }}</p>
    @endif

    <div class="admin-card p-6">
        <form action="{{ route('admin.profile.update', $profile->id) }}" method="POST">
            @csrf 
            @method('PUT')

            <div class="admin-input-group">
                <label>Hero Title</label>
                <input type="text" name="hero_title" 
                    value="{{ old('hero_title', $profile->hero_title) }}" 
                    class="silua-input-v2" required>
            </div>

            <div class="admin-input-group">
                <label>History</label>
                <textarea name="history_text" class="silua-input-v2" required>
{{ old('history_text', $profile->history_text) }}
                </textarea>
            </div>

            <div class="admin-input-group">
                <label>Vision</label>
                <textarea name="vision" class="silua-input-v2" required>
{{ old('vision', $profile->vision) }}
                </textarea>
            </div>

            <div class="admin-input-group">
                <label>Mission</label>
                <textarea name="mission" class="silua-input-v2" required>
{{ old('mission', $profile->mission) }}
                </textarea>
            </div>

            <div class="admin-input-group">
                <label>Map Embed</label>
                <input type="text" name="map_embed" 
                    value="{{ old('map_embed', $profile->map_embed) }}" 
                    class="silua-input-v2" required>
            </div>

            <button type="submit" class="btn-admin-submit-v2 mt-4 w-full">
                UPDATE
            </button>
        </form>
    </div>

</div>
@endsection