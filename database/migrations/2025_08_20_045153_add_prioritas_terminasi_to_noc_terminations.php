<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('noc_terminations', function (Blueprint $table) {
            $table->enum('prioritas_terminasi', ['High', 'Medium', 'Low'])->nullable()->after('status');
            $table->text('keterangan_tambahan')->nullable()->after('prioritas_terminasi');
        });
    }

    public function down()
    {
        Schema::table('noc_terminations', function (Blueprint $table) {
            $table->dropColumn(['prioritas_terminasi', 'keterangan_tambahan']);
        });
    }
};
