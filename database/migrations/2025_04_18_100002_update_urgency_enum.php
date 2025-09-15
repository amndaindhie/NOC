<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('noc_maintenance_requests', function (Blueprint $table) {
            $table->enum('tingkat_urgensi', ['Low', 'Medium', 'High', 'Critical'])->change();
        });
    }

    public function down()
    {
        Schema::table('noc_maintenance_requests', function (Blueprint $table) {
            $table->enum('tingkat_urgensi', ['High', 'Medium', 'Low'])->change();
        });
    }
};
