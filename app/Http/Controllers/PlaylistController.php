<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class PlaylistController extends Controller
{
    // Show playlist with songs
    public function index(Request $request)
    {
        $sort  = in_array($request->query('sort'), ['asc', 'desc'])
            ? $request->query('sort')
            : 'asc';

        $genre = $request->query('genre');

        $songsQuery = Song::whereHas('playlist', fn ($q) =>
            $q->where('user_id', Auth::id())
        );

        if ($genre) {
            $songsQuery->where('genre', $genre);
        }

        $songs = $songsQuery->orderBy('songname', $sort)->get();

        $playlist = Playlist::where('user_id', Auth::id())->first();

        $genres = Song::whereHas('playlist', fn ($q) =>
            $q->where('user_id', Auth::id())
        )->distinct()->pluck('genre');

        return view('playlists.show', compact(
            'songs',
            'playlist',
            'sort',
            'genres',
            'genre'
        ));
    }

    // Edit playlist name
    public function edit()
    {
        $playlist = Playlist::where('user_id', Auth::id())->first();

        return view('playlists.edit-playlist', compact('playlist'));
    }

    // Update playlist name
    public function update(Request $request)
    {
        $request->validate([
            'playlistname' => 'required|string|min:2',
        ]);

        $name = $request->playlistname;

        // No numbers allowed
        if (preg_match('/\d/', $name)) {
            throw ValidationException::withMessages([
                'playlistname' => 'Playlist name cannot contain numbers.'
            ]);
        }

        // Language validation
        $response = Http::withToken(env('DETECTLANGUAGE_KEY'))
            ->post('https://ws.detectlanguage.com/0.2/detect', [
                'q' => $name
            ]);

        $confidence = $response['data']['detections'][0]['confidence'] ?? 0;

        if ($confidence < 0.4) {
            throw ValidationException::withMessages([
                'playlistname' => 'Playlist name does not appear to be meaningful English.'
            ]);
        }

        Playlist::updateOrCreate(
            ['user_id' => Auth::id()],
            ['playlistname' => $name]
        );

        return redirect()->route('playlists.index')->with('success', 'Playlist name updated!');
    }
}
