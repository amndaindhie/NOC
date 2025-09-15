<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('noc_maintenance_requests', function (Blueprint $table) {
            // Drop existing jenis_masalah column
            $table->dropColumn('jenis_masalah');
            
            // Add new jenis_maintenance column with enum values matching installation types
            $table->enum('jenis_maintenance', ['Internet', 'CCTV', 'IoT', 'VPN', 'Lainnya'])->after('lokasi_perangkat');
            
            // Add tanggal_mulai and tanggal_selesai columns
            $table->date('tanggal_mulai')->after('tanggal_permintaan')->nullable();
            $table->date('tanggal_selesai')->after('tanggal_mulai')->nullable();
        });
    }

    public function down()
    {
        Schema::table('noc_maintenance_requests', function (Blueprint $table) {
            // Add back jenis_masalah column
            $table->enum('jenis_masalah', [
                'Koneksi Internet',
                'Perangkat CCTV',
                'Perangkat IoT',
                'Router/Switch',
                'Kabel Jaringan',
                'Lainnya'
            ])->after('lokasi_perangkat');
            
            // Drop new columns
            $table->dropColumn(['jenis_maintenance', 'tanggal_mulai', 'tanggal_selesai']);
        });
    }
};
