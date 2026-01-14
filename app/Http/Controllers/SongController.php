<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class SongController extends Controller
{
    // List songs with sorting and genre filter
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'asc');
        $genre = $request->query('genre', null);

        // Validate sorting direction
        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'asc';
        }

        $songsQuery = Song::whereHas('playlist', function ($query) {
            $query->where('user_id', Auth::id());
        });

        if ($genre) {
            $songsQuery->where('genre', $genre);
        }

        $songs = $songsQuery->orderBy('songname', $sort)->get();

        $playlist = Playlist::where('user_id', Auth::id())->first();

        // Get list of genres for filter dropdown
        $genres = Song::whereHas('playlist', fn($q) => $q->where('user_id', Auth::id()))
                      ->distinct()
                      ->pluck('genre');

        return view('playlists.show', compact('songs', 'playlist', 'sort', 'genres', 'genre'));
    }

    // Show create form
    public function create()
    {
        return view('playlists.create');
    }

    // Store song
    public function store(Request $request)
    {
        $request->validate([
            'songname' => 'required|string|min:2',
            'genre' => 'required|string|min:2',
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
        ]);

        $song->update($request->only('songname', 'genre'));

        return redirect()->route('playlists.index')->with('success', 'Song updated!');
    }

    // Delete song
    public function destroy(Song $song)
    {
        $song->delete();
        return redirect()->route('playlists.index')->with('success', 'Song deleted!');
    }

    // Edit playlist name
    public function editPlaylist()
    {
        $playlist = Playlist::where('user_id', Auth::id())->first();
        return view('playlists.edit-playlist', compact('playlist'));
    }

    // Update playlist name with API validation
    public function updatePlaylist(Request $request)
    {
        $request->validate([
            'playlistname' => 'required|string|min:2',
        ]);

        $playlistName = $request->playlistname;

        // No numbers allowed
        if (strpbrk($playlistName, '0123456789') !== false) {
            throw ValidationException::withMessages([
                'playlistname' => 'Playlist name cannot contain numbers.'
            ]);
        }

        // External API validation (DetectLanguage)
        $response = Http::withToken(env('DETECTLANGUAGE_KEY'))
            ->post('https://ws.detectlanguage.com/0.2/detect', [
                'q' => $playlistName
            ]);

        $confidence = $response['data']['detections'][0]['confidence'] ?? 0;

        if ($confidence < 0.4) {
            throw ValidationException::withMessages([
                'playlistname' => 'Playlist name does not appear to be meaningful English.'
            ]);
        }

        Playlist::updateOrCreate(
            ['user_id' => Auth::id()],
            ['playlistname' => $playlistName]
        );

        return redirect()->route('playlists.index')->with('success', 'Playlist name updated!');
    }
}
