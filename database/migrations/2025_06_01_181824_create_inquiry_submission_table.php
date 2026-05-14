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

        Schema::create('InquirySubmission', function (Blueprint $table) {
            $table->id('submissionID'); // PK
            $table->unsignedBigInteger('publicUserID'); // FK
            $table->foreign('publicUserID')->references('publicUserID')->on('PublicUser')->onDelete('cascade');
            $table->string('submissionTitle', 100);
            $table->string('submissionDescription', 255);
            $table->string('submissionCategory', 30);
            $table->string('submissionEvidence');
            $table->string('sourceOfNews', 100)->nullable();
            $table->date('submissionDate');
            $table->string('submissionStatus', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('InquirySubmission');
    }
};