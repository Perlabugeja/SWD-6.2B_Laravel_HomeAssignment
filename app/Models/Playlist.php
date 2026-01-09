<?php

namespace App\Models;

use App\Models\Song;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Playlist extends Model
{
    use HasFactory;

    public function songs(){
        return $this->hasMany(Song::class);
    }

     public function user(){
        return $this->hasOne(User::class);
    }

    // Enable Mass Assignment
    protected $fillable = ['playlistname', 'user_id'];
}


