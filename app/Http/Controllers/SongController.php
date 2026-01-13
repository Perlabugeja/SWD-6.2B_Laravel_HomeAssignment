<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SongController extends Controller
{
    // List all songs for the user's playlist
    public function index()
    {
        $songs = Song::whereHas('playlist', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $playlist = Playlist::where('user_id', Auth::id())->first();

        return view('playlists.show', compact('songs', 'playlist'));
    }

    // Show form to create a new song
    public function create()
    {
        return view('playlists.create');
    }

    // Store new song
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

    // Show form to edit a song
    public function edit(Song $song)
    {
        return view('songs.edit', compact('song'));
    }

    // Update a song
    public function update(Request $request, Song $song)
    {
        $request->validate([
            'songname' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
        ]);

        $song->update([
            'songname' => $request->songname,
            'genre' => $request->genre,
        ]);

        return redirect()->route('playlists.index')->with('success', 'Song updated!');
    }

    // Delete a song
    public function destroy(Song $song)
    {
        $song->delete();
        return redirect()->route('playlists.index')->with('success', 'Song deleted!');
    }

    // Show form to edit playlist name
    public function editPlaylist()
    {
        $playlist = Playlist::where('user_id', Auth::id())->first();
        return view('playlists.edit-playlist', compact('playlist'));
    }

    // Update playlist name with DetectLanguage API check
    public function updatePlaylist(Request $request)
    {
        $request->validate([
            'playlistname' => 'required|string|min:2',
        ]);

        $playlistName = $request->input('playlistname');

        try {
            $response = Http::withToken(env('DETECTLANGUAGE_KEY'))
                ->withOptions(['verify' => false]) // only for local dev
                ->post('https://ws.detectlanguage.com/v3/detect', [
                    'q' => $playlistName
                ]);

            $data = $response->json();

            // Debug: show full response from DetectLanguage
            dump($data);

            $englishDetected = false;

            // Loop through each detection
            if (is_array($data)) {
                foreach ($data as $detection) {
                    // Debug: show each detection individually
                    dump($detection);

                    if (isset($detection['language'], $detection['score']) &&
                        $detection['language'] === 'en' &&
                        $detection['score'] >= 0.1
                    ) {
                        $englishDetected = true;
                        break;
                    }
                }
            }

            if (!$englishDetected) {
                return back()->withErrors([
                    'playlistname' => 'Playlist name must be valid English words.'
                ]);
            }

        } catch (\Exception $e) {
            return back()->withErrors([
                'playlistname' => 'Error checking playlist name language: ' . $e->getMessage()
            ]);
        }

        // Update or create playlist
        Playlist::updateOrCreate(
            ['user_id' => Auth::id()],
            ['playlistname' => $playlistName]
        );

        return redirect()->route('playlists.index')->with('success', 'Playlist name updated!');
    }
}
