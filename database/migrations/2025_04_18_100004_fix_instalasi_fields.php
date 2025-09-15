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
        Schema::table('noc_installation_requests', function (Blueprint $table) {
            // Hapus field lama jika ada
            if (Schema::hasColumn('noc_installation_requests', 'tanggal_perintaan')) {
                $table->dropColumn('tanggal_perintaan');
            }
            
            // Tambahkan field yang benar
            if (!Schema::hasColumn('noc_installation_requests', 'tanggal_permintaan')) {
                $table->date('tanggal_permintaan')->nullable()->after('kecepatan_bandwidth');
            }
            
            if (!Schema::hasColumn('noc_installation_requests', 'waktu_instalasi')) {
                $table->string('waktu_instalasi')->nullable()->after('tanggal_instalasi');
            } else {
                // Ubah kolom yang sudah ada menjadi nullable
                $table->string('waktu_instalasi')->nullable()->change();
            }
            
            // Tambahkan field tingkat_urgensi
            if (!Schema::hasColumn('noc_installation_requests', 'tingkat_urgensi')) {
                $table->enum('tingkat_urgensi', ['Low', 'Medium', 'High', 'Critical'])->default('Medium')->after('waktu_instalasi');
            }
            
            // Ubah tanggal_instalasi menjadi nullable
            if (Schema::hasColumn('noc_installation_requests', 'tanggal_instalasi')) {
                $table->date('tanggal_instalasi')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noc_installation_requests', function (Blueprint $table) {
            if (Schema::hasColumn('noc_installation_requests', 'tanggal_permintaan')) {
                $table->dropColumn('tanggal_permintaan');
            }
            
            if (Schema::hasColumn('noc_installation_requests', 'waktu_instalasi')) {
                $table->dropColumn('waktu_instalasi');
            }
            
            if (Schema::hasColumn('noc_installation_requests', 'tingkat_urgensi')) {
                $table->dropColumn('tingkat_urgensi');
            }
        });
    }
};
