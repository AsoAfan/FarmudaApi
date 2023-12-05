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
        Schema::create('hadith', function (Blueprint $table) {
            $table->id();
            $table->longText('arabic');
            $table->longText('kurdish');
            $table->longText('badiny')->nullable();
            $table->longText('hawramy')->nullable();
            $table->longText("arabic_search");
            $table->longText('description')->nullable();
            // s => sahih, h => hasan, z => za`if, m => mawzu`
            $table->enum('hukim', ['s', 'h', 'z', 'm']);
            $table->unsignedInteger('hadith_number');
            $table->foreignId('teller_id')->references('id')->on('tellers')->cascadeOnDelete();
            $table->boolean('is_featured')->default(false);

//            $table->foreignId('buxari_chapter_id')->nullable()->references('id')->on('buxari_chapters')->cascadeOnDelete();


//            $table->foreignId('muslim_chapter_id')->nullable()->references('id')->on('muslim_chapters')->cascadeOnDelete();
//
//
//            $table->foreignId('hadith_favourite')->constrained()->cascadeOnDelete();

//            $table->foreignId('category_id')->references('id')->on('categories')->cascadeOnDelete();

            $table->timestamps();

            $table->index('created_at');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hadith');
    }
};
