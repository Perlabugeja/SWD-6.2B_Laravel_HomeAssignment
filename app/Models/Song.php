<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    public function playlist(){
        return $this->hasOne(Playlist::class);
    }

    // Enable Mass Assignment
    protected $fillable = ['id', 'songname', 'playlist_id'];
}
