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
        $sort = in_array($request->query('sort'), ['asc', 'desc'])
            ? $request->query('sort')
            : 'asc';

        $genre = $request->query('genre');

        $playlist = Playlist::where('user_id', Auth::id())->first();

        $songsQuery = Song::where('playlist_id', $playlist?->id ?? 0);

        if ($genre) {
            $songsQuery->where('genre', $genre);
        }

        $songs = $songsQuery->orderBy('songname', $sort)->get();

        $genres = Song::where('playlist_id', $playlist?->id ?? 0)
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
        $request->validate([
            'playlistname' => 'required|string|min:2',
        ]);

        $name = $request->playlistname;

        // Reject numbers & symbols (only letters and spaces allowed)
        foreach (str_split($name) as $char) {
            if (is_numeric($char)) {
                throw ValidationException::withMessages([
                    'playlistname' => 'Playlist name cannot contain numbers.'
                ]);
            }
            if (!ctype_alpha($char) && $char !== ' ') {
                throw ValidationException::withMessages([
                    'playlistname' => 'Playlist name can only contain letters and spaces (no symbols).'
                ]);
            }
        }

        // Check if name is English
        if (!$this->isEnglish($name)) {
            throw ValidationException::withMessages([
                'playlistname' => 'Playlist name does not appear to be meaningful English.'
            ]);
        }

        // Check for profanity
        $this->checkProfanity($name);

        // Create or update playlist
        Playlist::updateOrCreate(
            ['user_id' => Auth::id()],
            ['playlistname' => $name]
        );

        return redirect()->route('playlists.index')
            ->with('success', 'Playlist name updated!');
    }

    /* Check if text is English using DetectLanguage API */
    private function isEnglish(string $text): bool
    {
        $http = Http::withToken(env('DETECTLANGUAGE_KEY'));
        // Skip SSL verification locally
        if (app()->environment('local')) {
            $http = $http->withoutVerifying();
        }

        $response = $http->post('https://ws.detectlanguage.com/0.2/detect', ['q' => $text]);

        // Get confidence score of the detected language
        $confidence = $response['data']['detections'][0]['confidence'] ?? 0;

        // Return true if confidence is high enough to be considered English
        return $confidence >= 0.4;
    }

    /* Check for profanity using APILayer Bad Words API */
    private function checkProfanity(string $text)
    {
        $apiKey = env('APILAYER_BADWORDS_KEY');

        $http = Http::withHeaders([
            'apikey' => $apiKey,
        ]);

        // Skip SSL verification locally
        if (app()->environment('local')) {
            $http = $http->withoutVerifying();
        }

        $response = $http->post('https://api.apilayer.com/bad_words', [
            'body' => $text,
        ]);

        // Debug: uncomment to see API response
        // dd($response->json());

        if (!$response->ok()) {
            throw ValidationException::withMessages([
                'playlistname' => 'Unable to validate playlist name at this time.',
            ]);
        }

        $data = $response->json();

        // The API returns "bad_words_total" or "bad_words_list" depending on your plan
        $badWordsCount = $data['bad_words_total'] ?? 0;

        if ($badWordsCount > 0) {
            throw ValidationException::withMessages([
                'playlistname' => 'Playlist name contains inappropriate language.',
            ]);
        }
    }
}
