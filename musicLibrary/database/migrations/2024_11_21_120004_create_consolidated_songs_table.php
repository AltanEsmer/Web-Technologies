<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('spotify_id')->unique();
            $table->string('title')->index();
            $table->string('artist')->index();
            $table->string('album')->index();
            $table->string('cover_art')->nullable();
            $table->integer('duration_ms')->nullable();
            $table->json('audio_features')->nullable();
            $table->integer('popularity')->default(0);
            $table->boolean('explicit')->default(false);
            $table->json('genres')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('songs');
    }
};