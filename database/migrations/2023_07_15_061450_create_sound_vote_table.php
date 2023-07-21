<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundVoteTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sound_vote', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_id')->references('id')->on('sound')->onDelete('cascade');
            $table->string('song_id');
            $table->string('session_id');
            $table->boolean('skip');
            $table->timestamps();

            $table->unique(['session_id', 'song_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sound_vote');
    }
};
