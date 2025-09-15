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
        Schema::create('noc_installation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tenant');
            $table->string('nama_perusahaan');
            $table->string('nama_isp')->nullable();
            $table->string('nomor_npwp')->nullable();
            $table->string('kontak_person');
            $table->string('email')->nullable();
            $table->string('lokasi_instalasi');
            $table->enum('lokasi_pemasangan', [
                'BPSP / FSP',
                'Kavling',
                'Gedung Pengelola / Office Management',
                'Tower Rusun'
            ])->nullable();
            $table->string('nomor_telepon');
            $table->enum('jenis_layanan', ['Dedicated', 'Broadband']);
            $table->string('kecepatan_bandwidth')->nullable();
            $table->enum('skema_topologi', [
                'FTTx (BPSP, Rusunawa dan Gedung Pengelola)',
                'Direct Core / Konvensional (Pabrik / Manufaktur)'
            ])->nullable();
            $table->enum('tingkat_urgensi', ['Low', 'Medium', 'High', 'Critical'])->default('Medium');
            $table->date('tanggal_permintaan');
            $table->date('tanggal_instalasi')->nullable();
            $table->string('waktu_instalasi')->nullable();
            $table->text('catatan_tambahan')->nullable();
            $table->string('dokumen_path')->nullable();
            $table->enum('status', ['Diterima', 'Proses', 'Selesai', 'Ditolak'])->default('Diterima');
            $table->string('nomor_tiket')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noc_installation_requests');
    }
};
