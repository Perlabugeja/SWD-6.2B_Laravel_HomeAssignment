<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    public function index()
    {
        $songs = Song::whereHas('playlist', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('playlists.show', compact('songs'));
    }

    public function create()
    {
        return view('playlists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'songname' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
        ]);

        $playlist = Playlist::firstOrCreate(
            ['user_id' => Auth::id()],
            ['playlistname' => 'My Playlist']
        );

        Song::create([
            'songname' => $request->songname,
            'genre' => $request->genre,
            'playlist_id' => $playlist->id,
        ]);

        return redirect('/playlists')->with('success', 'Song added!');
    }


}
