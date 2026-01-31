@extends('layouts.main')

@section('title', 'Manage Songs')

@section('content')
<div class="playlist-page">
    <div class="table-wrapper">


        <!-- Header -->
        <div class="table-title d-flex justify-content-between align-items-center">
            <div>
                <h2>Manage <b>Songs</b></h2>
                <div class="playlist-name">{{ $playlist?->playlistname ?? 'My Playlist' }}</div>
            </div>

            <div>
                <a href="{{ route('songs.create') }}" class="btn btn-success">Add New Song</a>
                <a href="{{ route('playlist.edit') }}" class="btn btn-success">Edit Playlist Name</a>

                {{-- Optional: remove favourite --}}
                @if(!empty($favouriteSongId))
                    <form action="{{ route('favourite.remove') }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary">Remove Favourite</button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Sorting & Filtering -->
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="sort-buttons">
                <span class="me-2">Sort:</span>
                <a href="{{ route('playlists.index', array_merge(request()->query(), ['sort' => 'asc'])) }}"
                   class="btn btn-sm {{ request('sort', 'asc') === 'asc' ? 'active' : '' }}">
                    A–Z
                </a>
                <a href="{{ route('playlists.index', array_merge(request()->query(), ['sort' => 'desc'])) }}"
                   class="btn btn-sm {{ request('sort') === 'desc' ? 'active' : '' }}">
                    Z–A
                </a>
            </div>

            <form method="GET" action="{{ route('playlists.index') }}" class="d-flex align-items-center">
                <label for="genre" class="me-2 mb-0">Filter by Genre:</label>
                <select name="genre" id="genre" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                    <option value="">All</option>
                    @foreach($genres as $g)
                        <option value="{{ $g }}" {{ ($genre ?? '') === $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="sort" value="{{ $sort }}">
            </form>
        </div>

        <!-- Songs Table -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Song Name</th>
                    <th>Artist/Band</th>
                    <th>Genre</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($songs as $song)
                    <tr>
                        <td>{{ $song->songname }}</td>
                        <td>{{ $song->artist }}</td>
                        <td>{{ $song->genre }}</td>
                        <td>{{ $song->duration }}</td>

                        <td>
                            <a href="{{ route('songs.edit', $song) }}" class="btn btn-info btn-sm">Edit</a>

                            <form action="{{ route('songs.destroy', $song) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>

                            {{-- Favourite button --}}
                            <form action="{{ route('songs.favourite', $song) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm {{ ($favouriteSongId ?? null) === $song->id ? 'btn-success' : 'btn-secondary' }}">
                                    {{ ($favouriteSongId ?? null) === $song->id ? '★ Favourite' : 'Set Favourite' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Your playlist is empty or no songs match this genre. Add your first song.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
