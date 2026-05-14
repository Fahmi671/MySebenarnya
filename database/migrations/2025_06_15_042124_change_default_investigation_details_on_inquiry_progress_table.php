<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('InquiryProgress', function (Blueprint $table) {
            $table->string('investigationDetails', 100)->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('InquiryProgress', function (Blueprint $table) {
            $table->string('investigationDetails', 100)->default('None')->change();
        });
    }
};