<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('trackable'); // Can track activities for songs, playlists, etc.
            $table->string('activity_type')->index();
            $table->integer('duration')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'activity_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_activities');
    }
};