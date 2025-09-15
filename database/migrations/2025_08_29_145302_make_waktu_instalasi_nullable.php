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
            $table->string('waktu_instalasi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noc_installation_requests', function (Blueprint $table) {
            $table->string('waktu_instalasi')->nullable(false)->change();
        });
    }
};
