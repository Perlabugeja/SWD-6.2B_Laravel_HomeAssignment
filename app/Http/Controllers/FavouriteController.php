<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    // Set (or replace) the user's single favourite song
    public function set(Song $song)
    {
        Favourite::updateOrCreate(
            ['user_id' => Auth::id()],   
            ['song_id' => $song->id]     
        );

        return redirect()->route('playlists.index')
            ->with('success', 'Song successfully set as favourite!');
    }

    public function remove()
    {
        Favourite::where('user_id', Auth::id())->delete();

        return redirect()->route('playlists.index')
            ->with('success', 'Favourite song removed.');
    }
}
