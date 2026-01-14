@extends('layouts.main')

@section('title', 'Edit Song')

@section('content')
<div class="playlist-page">
    <div class="form-wrapper">
        <h2 class="text-center">Edit Song</h2>

        <form method="POST" action="{{ route('songs.update', $song) }}">
            @csrf
            @method('PUT')

            <!-- Song Name -->
            <div class="mb-3">
                <label for="songname" class="form-label">Song Name</label>
                <input type="text" id="songname" name="songname" class="form-control" value="{{ old('songname', $song->songname) }}" required>
                @error('songname')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <!-- Artist/Band -->
            <div class="mb-3">
                <label for="artist" class="form-label">Artist/Band</label>
                <input type="text" id="artist" name="artist" class="form-control" value="{{ old('artist', $song->artist) }}" required>
                @error('artist')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <!-- Genre -->
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" id="genre" name="genre" class="form-control" value="{{ old('genre', $song->genre) }}" required>
                @error('genre')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <!-- Duration -->
            <div class="mb-3">
                <label for="duration" class="form-label">Duration (mm:ss)</label>
                <input type="text" id="duration" name="duration" class="form-control" value="{{ old('duration', $song->duration) }}" placeholder="e.g. 03:45" required>
                @error('duration')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Update Song</button>
                <a href="{{ route('playlists.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
