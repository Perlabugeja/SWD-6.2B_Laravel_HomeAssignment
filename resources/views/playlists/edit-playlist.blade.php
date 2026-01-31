@extends('layouts.main')

@section('title', 'Edit Playlist Name')

@section('content')
<div class="playlist-page">
    <div class="form-wrapper">


        <h2 class="text-center">Edit Playlist Name</h2>

        <form method="POST" action="{{ route('playlists.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="playlistname" class="form-label">Playlist Name</label>
                <input
                    type="text"
                    id="playlistname"
                    name="playlistname"
                    class="form-control"
                    value="{{ old('playlistname', $playlist->playlistname ?? '') }}"
                >
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
