@extends('layouts.main')

@section('title', 'Edit Song')

@push('styles')
<style>
.edit-page {
    color: #566787;
    font-family: 'Varela Round', sans-serif;
    background: #f5f5f5;
}
.card-wrapper {
    background: #fff;
    padding: 20px 25px;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
    margin-top: 50px;
}
.card-wrapper h2 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
    color: #364658ff;
}
.btn-group {
    margin-top: 15px;
}
</style>
@endpush

@section('content')
<div class="container edit-page">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-wrapper">
                <h2>Edit Song</h2>

                <form action="{{ route('songs.update', $song) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Song Name</label>
                        <input type="text" name="songname" class="form-control" value="{{ old('songname', $song->songname) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Genre</label>
                        <input type="text" name="genre" class="form-control" value="{{ old('genre', $song->genre) }}" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Update Song</button>
                        <a href="{{ route('playlists.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
