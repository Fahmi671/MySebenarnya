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
        Schema::create('Agency', function (Blueprint $table) {
            $table->id('userID'); // Auto-increment PK
            $table->unsignedBigInteger('agencyID')->unique();
            $table->foreign('userID')->references('userID')->on('Users')->onDelete('cascade');
            $table->string('agencyName', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Agency');
    }
};
