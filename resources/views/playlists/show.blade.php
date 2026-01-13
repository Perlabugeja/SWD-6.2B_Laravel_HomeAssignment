@extends('layouts.main')

@section('title', 'Manage Songs')

@push('styles')
<style>
body {
    color: #566787;
    background: #f5f5f5;
    font-family: 'Varela Round', sans-serif;
    font-size: 13px;
}
.table-wrapper {
    background: #fff;
    padding: 20px 25px;
    margin: 30px 0;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {
    padding: 16px 30px;
    margin-bottom: 15px;
    background: #364658;
    color: #fff;
    border-radius: 3px 3px 0 0;
}
.table-title h2 {
    margin: 0;
    font-size: 24px;
}
.table-title .playlist-name {
    text-align: center;
    font-size: 16px;
    opacity: 0.9;
    margin-top: 5px;
}
.table-title .btn {
    color: #fff;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: #fcfcfc;
}
.table-striped.table-hover tbody tr:hover {
    background: #f5f5f5;
}
.table td a.btn {
    font-size: 12px;
    padding: 3px 8px;
}
</style>
@endpush

@section('content')
<div class="playlist-page">
    <div class="table-wrapper">
        <div class="table-title d-flex justify-content-between align-items-center">
            <div>
                <h2>Manage <b>Songs</b></h2>

                <!-- Playlist name displayed -->
                <div class="playlist-name">
                    {{ $playlist?->playlistname ?? 'My Playlist' }}  <!-- Find playlist exist get playlistname if not display my playlist -->
                </div>
            </div>

            <div>
                <a href="{{ route('songs.create') }}" class="btn btn-success">Add New Song</a>
                <a href="{{ route('playlist.edit') }}" class="btn btn-primary">Edit Playlist Name</a>
            </div>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Song Name</th>
                    <th>Genre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($songs as $song)
                <tr>
                    <td>{{ $song->songname }}</td>
                    <td>{{ $song->genre }}</td>
                    <td>
                        <a href="{{ route('songs.edit', $song) }}" class="btn btn-info btn-sm">Edit</a>
                        <form action="{{ route('songs.destroy', $song) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        Your playlist is empty. Add your first song.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
