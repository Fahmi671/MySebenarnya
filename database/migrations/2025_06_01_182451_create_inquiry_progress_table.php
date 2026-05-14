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
        Schema::create('InquiryProgress', function (Blueprint $table) {
            $table->id('progressID'); // PK
            $table->unsignedBigInteger('assignmentID'); // FK
            $table->unsignedBigInteger('submissionID'); // FK
            $table->unsignedBigInteger('agencyID'); // FK
            $table->foreign('assignmentID')->references('assignmentID')->on('SubmissionAssignment')->onDelete('cascade');
            $table->foreign('submissionID')->references('submissionID')->on('InquirySubmission')->onDelete('cascade');
            $table->foreign('agencyID')->references('agencyID')->on('Agency')->onDelete('cascade');
            $table->string('verificationStatus', 50);
            $table->date('verificationDate');
            $table->string('investigationDetails', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('InquiryProgress');
    }
};
