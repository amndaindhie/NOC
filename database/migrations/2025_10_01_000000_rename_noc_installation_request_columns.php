<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameNocInstallationRequestColumns extends Migration
{
    public function up()
    {
        Schema::table('noc_installation_requests', function (Blueprint $table) {
            if (Schema::hasColumn('noc_installation_requests', 'nama_penanggung_jawab')) {
                $table->renameColumn('nama_penanggung_jawab', 'kontak_person');
            }
            if (Schema::hasColumn('noc_installation_requests', 'alamat_instalasi')) {
                $table->renameColumn('alamat_instalasi', 'lokasi_instalasi');
            }
            if (Schema::hasColumn('noc_installation_requests', 'nomor_handphone')) {
                $table->renameColumn('nomor_handphone', 'nomor_telepon');
            }
            if (Schema::hasColumn('noc_installation_requests', 'kapasitas_bandwidth')) {
                $table->renameColumn('kapasitas_bandwidth', 'kecepatan_bandwidth');
            }
        });
    }

    public function down()
    {
        Schema::table('noc_installation_requests', function (Blueprint $table) {
            if (Schema::hasColumn('noc_installation_requests', 'kontak_person')) {
                $table->renameColumn('kontak_person', 'nama_penanggung_jawab');
            }
            if (Schema::hasColumn('noc_installation_requests', 'lokasi_instalasi')) {
                $table->renameColumn('lokasi_instalasi', 'alamat_instalasi');
            }
            if (Schema::hasColumn('noc_installation_requests', 'nomor_telepon')) {
                $table->renameColumn('nomor_telepon', 'nomor_handphone');
            }
            if (Schema::hasColumn('noc_installation_requests', 'kecepatan_bandwidth')) {
                $table->renameColumn('kecepatan_bandwidth', 'kapasitas_bandwidth');
            }
        });
    }
}
