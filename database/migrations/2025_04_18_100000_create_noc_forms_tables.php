<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Form Pengajuan Instalasi Jaringan
        Schema::create('noc_installation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tenant');
            $table->string('nama_perusahaan');
            $table->string('nama_penanggung_jawab');
            $table->string('email')->nullable();
            $table->string('nama_isp')->nullable();
            $table->string('nomor_npwp')->nullable();
            $table->string('alamat_instalasi');
            $table->enum('lokasi_pemasangan', [
                'BPSP / FSP',
                'Kavling',
                'Gedung Pengelola / Office Management',
                'Tower Rusun'
            ])->nullable();
            $table->string('nomor_handphone');
            $table->enum('jenis_layanan', ['Dedicated', 'Broadband']);
            $table->string('kapasitas_bandwidth')->nullable();
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

        // Form Permintaan Maintenance
        Schema::create('noc_maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tenant');
            $table->string('nama_tenant');
            $table->string('lokasi_perangkat');
            $table->enum('jenis_masalah', [
                'Koneksi Internet',
                'Perangkat CCTV',
                'Perangkat IoT',
                'Router/Switch',
                'Kabel Jaringan',
                'Lainnya'
            ]);
            $table->text('deskripsi_masalah');
            $table->string('foto_path')->nullable();
            $table->string('video_path')->nullable();
            $table->enum('tingkat_urgensi', ['High', 'Medium', 'Low']);
            $table->date('tanggal_permintaan');
            $table->enum('status', ['Diterima', 'Proses', 'Selesai', 'Ditolak'])->default('Diterima');
            $table->string('nomor_tracking')->unique();
            $table->timestamps();
        });

        // Form Keluhan Jaringan
        Schema::create('noc_complaints', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tenant');
            $table->string('nama_tenant');
            $table->string('kontak_person');
            $table->enum('jenis_gangguan', ['Internet', 'CCTV', 'IoT', 'VPN', 'Lainnya']);
            $table->dateTime('waktu_mulai_gangguan');
            $table->text('deskripsi_gangguan');
            $table->string('bukti_path')->nullable();
            $table->enum('status', ['Diterima', 'Proses', 'Selesai', 'Ditolak'])->default('Diterima');
            $table->string('nomor_tiket')->unique();
            $table->timestamps();
        });

        // Form Terminasi Layanan
        Schema::create('noc_terminations', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tenant');
            $table->string('nama_tenant');
            $table->string('lokasi');
            $table->enum('alasan_terminasi', [
                'Pindah Lokasi',
                'Tidak Membutuhkan Layanan',
                'Pindah Provider',
                'Masalah Teknis',
                'Lainnya'
            ]);
            $table->date('tanggal_efektif');
            $table->string('dokumen_path')->nullable();
            $table->boolean('konfirmasi_setuju');
            $table->enum('status', ['Diterima', 'Proses', 'Selesai', 'Ditolak'])->default('Diterima');
            $table->string('nomor_tiket')->unique();
            $table->timestamps();
        });

        // Tracking Status Permintaan
        Schema::create('noc_tracking_status', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tiket');
            $table->string('jenis_form'); // instalasi, maintenance, keluhan, terminasi
            $table->enum('status', ['Diterima', 'Proses', 'Selesai', 'Ditolak']);
            $table->text('catatan')->nullable();
            $table->dateTime('estimasi_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('noc_installation_requests');
        Schema::dropIfExists('noc_maintenance_requests');
        Schema::dropIfExists('noc_complaints');
        Schema::dropIfExists('noc_terminations');
        Schema::dropIfExists('noc_tracking_status');
    }
};
