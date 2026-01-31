<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'songname',
        'genre',
        'playlist_id',
        'artist',
        'duration'
    ];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
    
        public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

}
