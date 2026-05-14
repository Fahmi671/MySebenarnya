<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('InquiryProgress', function (Blueprint $table) {
            $table->string('SupportingDocuments', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('InquiryProgress', function (Blueprint $table) {
            $table->dropColumn('SupportingDocuments');
        });
    }
};