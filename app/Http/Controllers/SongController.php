<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    // Show add song form
    public function create()
    {
        return view('songs.create');
    }

    // Store song
    public function store(Request $request)
    {
        $request->validate([
            'songname' => 'required|string|min:2',
            'genre' => 'required|string|min:2',
            'artist' => 'required|string|min:2',
            'duration' => 'required|string|min:1', 
        ]);

        $playlist = Playlist::firstOrCreate(
            ['user_id' => Auth::id()],
            ['playlistname' => 'My Playlist']
        );

        Song::create([
            'songname' => $request->songname,
            'genre' => $request->genre,
            'artist' => $request->artist,
            'duration' => $request->duration,
            'playlist_id' => $playlist->id,
        ]);

        return redirect()->route('playlists.index')->with('success', 'Song added!');
    }

    // Edit song
    public function edit(Song $song)
    {
        return view('songs.edit', compact('song'));
    }

    // Update song
    public function update(Request $request, Song $song)
    {
        $request->validate([
            'songname' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'duration' => 'required|string|max:10',
        ]);

        $song->update($request->only('songname', 'genre', 'artist', 'duration'));

        return redirect()->route('playlists.index')->with('success', 'Song updated!');
    }

    // Delete song
    public function destroy(Song $song)
    {
        $song->delete();

        return redirect()->route('playlists.index')->with('success', 'Song deleted!');
    }
}
