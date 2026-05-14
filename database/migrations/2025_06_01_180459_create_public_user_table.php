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
        Schema::create('PublicUser', function (Blueprint $table) {
            $table->id('userID'); // Auto-increment PK
            $table->unsignedBigInteger('publicUserID')->unique(); // Unique subclass-specific FK
            $table->foreign('userID')->references('userID')->on('Users')->onDelete('cascade');
            $table->integer('publicUserAge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PublicUser');
    }
};
