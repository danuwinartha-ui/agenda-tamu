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
        Schema::table('agendas', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada untuk menghindari error double
            if (!Schema::hasColumn('agendas', 'tujuan_agenda')) {
                $table->string('tujuan_agenda')->nullable()->after('kegiatan');
            }
            if (!Schema::hasColumn('agendas', 'asal_bidang')) {
                $table->string('asal_bidang')->nullable()->after('tujuan_agenda');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn(['tujuan_agenda', 'asal_bidang']);
        });
    }
};