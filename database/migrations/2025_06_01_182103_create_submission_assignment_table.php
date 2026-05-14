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
        Schema::create('SubmissionAssignment', function (Blueprint $table) {
            $table->id('assignmentID'); // PK
            $table->unsignedBigInteger('agencyID'); // FK
            $table->unsignedBigInteger('MCMCStaffID'); // FK
            $table->unsignedBigInteger('submissionID'); // FK
            $table->foreign('agencyID')->references('agencyID')->on('Agency')->onDelete('cascade');
            $table->foreign('MCMCStaffID')->references('MCMCStaffID')->on('MCMCStaff')->onDelete('cascade');
            $table->foreign('submissionID')->references('submissionID')->on('InquirySubmission')->onDelete('cascade');
            $table->date('assignmentDate');
            $table->string('jurisdictionStatus', 50);
            $table->string('comment', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SubmissionAssignment');
    }
};
