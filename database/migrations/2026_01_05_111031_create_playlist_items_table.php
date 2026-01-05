<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('playlist_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('mood');
            

            //$table->foreign('playlist_id')->references('id')->on('playlist');
            //$table->foreign('song_id')->references('id')->on('song');

            $table->foreignId('playlist_id')->constrained();
            $table->foreignId('song_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_items');
    }
};
