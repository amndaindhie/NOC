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
        Schema::table('noc_maintenance_requests', function (Blueprint $table) {
            $table->string('bukti_selesai_path')->nullable()->after('dokumen_path');
            $table->string('bukti_selesai_filename')->nullable()->after('bukti_selesai_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noc_maintenance_requests', function (Blueprint $table) {
            $table->dropColumn(['bukti_selesai_path', 'bukti_selesai_filename']);
        });
    }
};
