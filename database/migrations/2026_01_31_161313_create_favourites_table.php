<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('favourites', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('song_id')->constrained()->cascadeOnDelete();

            $table->timestamps();

            // ONE favourite per user (0 or 1 row per user)
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favourites');
    }
};
