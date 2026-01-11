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
    // Display all songs for the user's playlists
    public function index()
    {
        $songs = Song::whereHas('playlist', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('playlists.show', compact('songs'));
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

        // Default playlist or first playlist of the user
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

// Show form to edit playlist name
public function editPlaylist()
{
    // Get the user's playlist or create a default one
    $playlist = Playlist::firstOrCreate(
        ['user_id' => Auth::id()],
        ['playlistname' => 'My Playlist'] // default name if none exists
    );

    return view('playlists.edit-playlist', compact('playlist'));
}

// Update playlist name
public function updatePlaylist(Request $request)
{
    $request->validate([
        'playlistname' => 'required|string|min:2',
    ]);

    $playlist = Playlist::where('user_id', Auth::id())->first();

    // No numbers allowed
    if (strpbrk($request->playlistname, '0123456789') !== false) {
        return back()->withErrors(['playlistname' => 'Playlist name cannot contain numbers.']);
    }

    // External API – gibberish detection (skip if local to avoid SSL errors)
    if (config('app.env') !== 'local') {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.detectlanguage.key'),
            ])->post('https://ws.detectlanguage.com/0.2/detect', [
                'q' => $request->playlistname
            ]);

            $confidence = $response['data']['detections'][0]['confidence'] ?? 0;

            if ($confidence < 0.4) {
                return back()->withErrors(['playlistname' => 'Playlist name does not appear to be meaningful.']);
            }
        } catch (\Exception $e) {
            // API failed, log but allow local update
            info('DetectLanguage API failed: ' . $e->getMessage());
        }
    }

    // Update playlist name
    $playlist->update([
        'playlistname' => $request->playlistname
    ]);

    return redirect()->route('playlists.index')->with('success', 'Playlist name updated!');
}

}
