@extends('layouts.main')

@section('title', 'Edit Song')

@section('content')
<div class="playlist-page">
    <div class="form-wrapper">
        <h2 class="text-center">Edit Song</h2>

        <form method="POST" action="{{ route('songs.update', $song) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="songname" class="form-label">Song Name</label>
                <input
                    type="text"
                    id="songname"
                    name="songname"
                    class="form-control"
                    value="{{ old('songname', $song->songname) }}"
                    required
                >
                @error('songname')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input
                    type="text"
                    id="genre"
                    name="genre"
                    class="form-control"
                    value="{{ old('genre', $song->genre) }}"
                    required
                >
                @error('genre')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Update Song</button>
                <a href="{{ route('playlists.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
