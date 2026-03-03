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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('instansi');
            $table->string('jabatan')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('pejabat_ditemui')->nullable();
            $table->text('tujuan_kunjungan')->nullable();
            $table->string('jam_isi')->nullable();
            $table->longText('swafoto')->nullable();
            $table->longText('tanda_tangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};