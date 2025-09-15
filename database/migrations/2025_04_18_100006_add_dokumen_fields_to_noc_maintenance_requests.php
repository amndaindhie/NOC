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
        Schema::table('noc_maintenance_requests', function (Blueprint $table) {
            $table->string('dokumen_path')->nullable()->after('deskripsi_masalah');
            $table->string('dokumen_filename')->nullable()->after('dokumen_path');
            $table->string('dokumen_mime_type')->nullable()->after('dokumen_filename');
            $table->unsignedBigInteger('dokumen_size')->nullable()->after('dokumen_mime_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noc_maintenance_requests', function (Blueprint $table) {
            $table->dropColumn(['dokumen_path', 'dokumen_filename', 'dokumen_mime_type', 'dokumen_size']);
        });
    }
};
