@extends('layouts.main')

@section('title', 'Edit Playlist Name')

@push('styles')
<style>
.playlist-page .form-wrapper {
    background: #fff;
    padding: 25px 30px;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.playlist-page h2 {
    color: #435d7d;
    text-align: center;
    margin-bottom: 20px;
}
</style>
@endpush

@section('content')
<div class="playlist-page">
    <div class="form-wrapper mx-auto" style="max-width: 500px;">
        <h2>Edit Playlist Name</h2>

        <form method="POST" action="{{ route('playlists.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="playlistname" class="form-label">Playlist Name</label>
                <input type="text" id="playlistname" name="playlistname" class="form-control"
                       value="{{ old('playlistname', $playlist->playlistname ?? 'My Playlist') }}" required>
                @error('playlistname')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Update Playlist</button>
                <a href="{{ route('playlists.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
