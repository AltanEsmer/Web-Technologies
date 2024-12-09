<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('playlists', function (Blueprint $table) {
            if (!Schema::hasColumn('playlists', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('playlists', function (Blueprint $table) {
            if (Schema::hasColumn('playlists', 'cover_image')) {
                $table->dropColumn('cover_image');
            }
        });
    }
};
