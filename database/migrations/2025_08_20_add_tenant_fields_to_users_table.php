<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_tenant')->default(false)->after('email_verified_at');
            $table->timestamp('tenant_activated_at')->nullable()->after('is_tenant');
            $table->integer('tenant_entry_count')->default(0)->after('tenant_activated_at');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_tenant', 'tenant_activated_at', 'tenant_entry_count']);
        });
    }
};
