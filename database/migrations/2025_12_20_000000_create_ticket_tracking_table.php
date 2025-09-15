<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ticket_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tiket')->index();
            $table->string('tipe_tiket'); // instalasi, maintenance, keluhan, terminasi
            $table->string('status');
            $table->text('keterangan')->nullable();
            $table->timestamp('waktu_perubahan');
            $table->string('dilakukan_oleh')->nullable();
            $table->timestamps();
            
            $table->index(['nomor_tiket', 'tipe_tiket']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_tracking');
    }
};
