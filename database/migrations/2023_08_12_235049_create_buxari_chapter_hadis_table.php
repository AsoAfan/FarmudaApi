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
        Schema::create('buxari_chapter_hadis', function (Blueprint $table) {
            $table->foreignId('hadis_id')->constrained()->cascadeOnDelete();
            $table->foreignId('buxari_chapter_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buxari_chapters_hadis');
    }
};
