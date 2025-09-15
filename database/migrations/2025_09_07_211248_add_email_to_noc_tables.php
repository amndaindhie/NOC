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
        if (!Schema::hasColumn('noc_installation_requests', 'email')) {
            Schema::table('noc_installation_requests', function (Blueprint $table) {
                $table->string('email')->nullable()->after('nomor_tenant');
            });
        }

        if (!Schema::hasColumn('noc_maintenance_requests', 'email')) {
            Schema::table('noc_maintenance_requests', function (Blueprint $table) {
                $table->string('email')->nullable()->after('nomor_tenant');
            });
        }

        if (!Schema::hasColumn('noc_complaints', 'email')) {
            Schema::table('noc_complaints', function (Blueprint $table) {
                $table->string('email')->nullable()->after('nomor_tenant');
            });
        }

        if (!Schema::hasColumn('noc_terminations', 'email')) {
            Schema::table('noc_terminations', function (Blueprint $table) {
                $table->string('email')->nullable()->after('nomor_tenant');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('noc_installation_requests', function (Blueprint $table) {
            $table->dropColumn('email');
        });

        Schema::table('noc_maintenance_requests', function (Blueprint $table) {
            $table->dropColumn('email');
        });

        Schema::table('noc_complaints', function (Blueprint $table) {
            $table->dropColumn('email');
        });

        Schema::table('noc_terminations', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
