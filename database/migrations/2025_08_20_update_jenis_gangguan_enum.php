<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('noc_complaints', function (Blueprint $table) {
            $table->dropColumn('jenis_gangguan');
        });
        
        Schema::table('noc_complaints', function (Blueprint $table) {
            $table->enum('jenis_gangguan', [
                'Internet Tidak Terhubung',
                'Kecepatan Lambat',
                'Koneksi Terputus',
                'CCTV Tidak Berfungsi',
                'IoT Tidak Merespon',
                'VPN Tidak Terhubung',
                'Lainnya'
            ])->after('nomor_tiket');
        });
    }

    public function down()
    {
        Schema::table('noc_complaints', function (Blueprint $table) {
            $table->dropColumn('jenis_gangguan');
        });
        
        Schema::table('noc_complaints', function (Blueprint $table) {
            $table->enum('jenis_gangguan', ['Internet', 'CCTV', 'IoT', 'VPN', 'Lainnya'])->after('nomor_tiket');
        });
    }
};
