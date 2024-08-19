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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('number')->nullable();
            $table->foreignId('album_id')->constrained();
            $table->foreignId('artist_id')->constrained();
            $table->string('name')->nullable();
            $table->mediumText('lyric')->nullable();
            $table->timestamps();

            // indexes:
            $table->fulltext('lyric');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
