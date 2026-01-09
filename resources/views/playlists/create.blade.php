@extends('layouts.main')

@section('title', 'Add New Song')

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
}
</style>
@endpush

@section('content')
<div class="playlist-page">
    <div class="form-wrapper mx-auto" style="max-width: 500px;">
        <h2 class="mb-4 text-center">Add New Song</h2>

        <form method="POST" action="{{ route('songs.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Song Name</label>
                <input type="text" name="songname" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Genre</label>
                <input type="text" name="genre" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Add Song</button>
                <a href="{{ route('playlists.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
