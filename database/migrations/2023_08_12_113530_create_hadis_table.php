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
        Schema::create('hadis', function (Blueprint $table) {
            $table->id();
            $table->longText('arabic');
            $table->longText('kurdish');
            $table->longText("arabic_search");
            $table->longText('description');
            $table->unsignedInteger('hadis_number');
            $table->foreignId('teller_id')->references('id')->on('tellers')->cascadeOnDelete();
            $table->boolean('is_featured')->default(false);

//            $table->foreignId('buxari_chapter_id')->nullable()->references('id')->on('buxari_chapters')->cascadeOnDelete();


//            $table->foreignId('muslim_chapter_id')->nullable()->references('id')->on('muslim_chapters')->cascadeOnDelete();
//
//
//            $table->foreignId('hadis_favourite')->constrained()->cascadeOnDelete();

//            $table->foreignId('category_id')->references('id')->on('categories')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hadis');
    }
};
