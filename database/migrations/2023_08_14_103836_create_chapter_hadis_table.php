<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chapter_hadis', function (Blueprint $table) {
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hadis_id')->constrained()->cascadeOnDelete();

            $table->unique(['chapter_id', 'hadis_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapter_hadis');
    }
};
