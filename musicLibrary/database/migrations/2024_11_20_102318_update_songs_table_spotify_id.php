<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('songs', function (Blueprint $table) {
            // Drop the existing spotify_id column
            $table->dropColumn('spotify_id');
            
            // Add it back with the desired properties
            $table->string('spotify_id')->after('id')->unique();
        });
    }

    public function down()
    {
        Schema::table('songs', function (Blueprint $table) {
            // In case of rollback, revert to original state
            $table->dropColumn('spotify_id');
            $table->string('spotify_id')->after('id');
        });
    }
};
