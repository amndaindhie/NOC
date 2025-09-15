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
        // Migration ini tidak perlu karena field sudah ada di migration utama
        // Hapus atau comment saja
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu aksi karena field sudah ada di migration utama
    }
};
