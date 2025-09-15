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
        Schema::table('noc_complaints', function (Blueprint $table) {
            $table->enum('tingkat_urgensi', ['Low', 'Medium', 'High', 'Critical'])->default('Medium')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noc_complaints', function (Blueprint $table) {
            $table->dropColumn('tingkat_urgensi');
        });
    }
};
