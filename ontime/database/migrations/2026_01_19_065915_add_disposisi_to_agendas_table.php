<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            // Tambahkan pengecekan if (!Schema::hasColumn(...))
            if (!Schema::hasColumn('agendas', 'disposisi')) {
                $table->text('disposisi')->nullable()->after('dari_instansi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            if (Schema::hasColumn('agendas', 'disposisi')) {
                $table->dropColumn('disposisi');
            }
        });
    }
};