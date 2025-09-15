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
        Schema::table('noc_terminations', function (Blueprint $table) {
            $table->dropColumn('prioritas_terminasi');
            $table->enum('prioritas_terminasi', ['Low', 'Medium', 'High', 'Critical'])->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noc_terminations', function (Blueprint $table) {
            $table->dropColumn('prioritas_terminasi');
            $table->enum('prioritas_terminasi', ['High', 'Medium', 'Low'])->nullable()->after('status');
        });
    }
};
