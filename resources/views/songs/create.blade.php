@extends('layouts.main')

@section('title', 'Add New Song')

@section('content')
<div class="playlist-page">
    <div class="form-wrapper">
        <h2 class="text-center">Add New Song</h2>

        <form method="POST" action="{{ route('songs.store') }}">
            @csrf

            <div class="mb-3">
                <label for="songname" class="form-label">Song Name</label>
                <input type="text" id="songname" name="songname" class="form-control" value="{{ old('songname') }}">
                @error('songname')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="artist" class="form-label">Artist/Band</label>
                <input type="text" id="artist" name="artist" class="form-control" value="{{ old('artist') }}" >
                @error('artist')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" id="genre" name="genre" class="form-control" value="{{ old('genre') }}" >
                @error('genre')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="duration" class="form-label">Duration (mm:ss)</label>
                <input type="text" id="duration" name="duration" class="form-control" value="{{ old('duration') }}" placeholder="03:45" >
                @error('duration')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Add Song</button>
                <a href="{{ route('playlists.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
