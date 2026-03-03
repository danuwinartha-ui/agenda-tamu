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
    Schema::create('agendas', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->time('waktu');
        $table->string('dari_instansi');
        $table->string('perihal');
        $table->text('kegiatan');
        $table->string('tempat');
        $table->string('disposisi')->nullable();
        $table->enum('status', ['tampil', 'sembunyi'])->default('tampil');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
