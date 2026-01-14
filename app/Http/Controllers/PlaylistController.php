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
    /**
     * Display the user's playlist and songs
     * Supports sorting (A–Z / Z–A) and genre filtering
     */
    public function index(Request $request)
    {
        $sort = in_array($request->query('sort'), ['asc', 'desc'])? $request->query('sort'): 'asc';

        $genre = $request->query('genre');

        $songsQuery = Song::whereHas('playlist', fn($q) => $q->where('user_id', Auth::id()));

        if ($genre) {
            $songsQuery->where('genre', $genre);
        }

        $songs = $songsQuery->orderBy('songname', $sort)->get();
        $playlist = Playlist::where('user_id', Auth::id())->first();
        $genres = Song::whereHas('playlist', fn($q) => $q->where('user_id', Auth::id()))
            ->distinct()
            ->pluck('genre');

        return view('playlists.show', compact('songs', 'playlist', 'sort', 'genres', 'genre'));
    }

    /* Show form to edit playlist name */
    public function edit()
    {
        $playlist = Playlist::where('user_id', Auth::id())->first();
        return view('playlists.edit-playlist', compact('playlist'));
    }

    /* Update playlist name with validation */
    public function update(Request $request)
    {
        // Basic validation
        $request->validate([
            'playlistname' => 'required|string|min:2',
        ]);

        $name = $request->playlistname;

        // Reject numbers & symbols (only letters and spaces allowed)
        foreach (str_split($name) as $char) {
            if (is_numeric($char)) throw ValidationException::withMessages([
                'playlistname' => 'Playlist name cannot contain numbers.'
            ]);
            if (!ctype_alpha($char) && $char !== ' ') throw ValidationException::withMessages([
                'playlistname' => 'Playlist name can only contain letters and spaces (no symbols).'
            ]);
        }

        // Check if name is English
        if (!$this->isEnglish($name)) {
            throw ValidationException::withMessages([
                'playlistname' => 'Playlist name does not appear to be meaningful English.'
            ]);
        }

        // Create or update playlist
        Playlist::updateOrCreate(
            ['user_id' => Auth::id()],
            ['playlistname' => $name]
        );

        return redirect()->route('playlists.index')
            ->with('success', 'Playlist name updated!');
    }

    /*Check if text is English using DetectLanguage API*/
    private function isEnglish(string $text): bool
    {
        $http = Http::withToken(env('DETECTLANGUAGE_KEY'));

        // Skip SSL verification in local dev
        if (app()->environment('local')) {
            $http = $http->withoutVerifying();
        }

        $response = $http->post('https://ws.detectlanguage.com/0.2/detect', ['q' => $text]);

        $confidence = $response['data']['detections'][0]['confidence'] ?? 0;

        return $confidence >= 0.4;
    }
}
