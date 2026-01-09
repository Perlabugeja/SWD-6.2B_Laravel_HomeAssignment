<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'songname',
        'genre',
        'playlist_id',
    ];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}
