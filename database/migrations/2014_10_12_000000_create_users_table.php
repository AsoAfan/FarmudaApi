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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->enum('role', ['admin', 'guider', 'user'])->default('user');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('otp_secret')->nullable();
            $table->string('otp_secret_slug')->nullable(); // TODO:refactor later
            $table->timestamp('otp_expires_at')->nullable();
            $table->integer('otp_attempt_count')->default(0);
            $table->timestamp('latest_otp_attempt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
