<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('noc_terminations', function (Blueprint $table) {
            // Change the status enum to match the expected values
            $table->enum('status', ['Pending', 'Diproses', 'Disetujui', 'Ditolak'])->default('Pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('noc_terminations', function (Blueprint $table) {
            // Revert back to the old enum values
            $table->enum('status', ['Diterima', 'Proses', 'Selesai', 'Ditolak'])->default('Diterima')->change();
        });
    }
};
