<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    /**
     * Karena kita menggunakan Shared Database, model ini diarahkan 
     * untuk membaca tabel 'users' yang ada di database db_diskominfo.
     * Tabel ini merupakan tabel utama dari aplikasi Agenda (ON-TIME).
     */
    protected $table = 'users';

    /**
     * Kolom yang dapat dibaca. 
     * Kita hanya memerlukan 'name' untuk ditampilkan di dropdown 
     * dan 'role' jika Anda ingin memfilter hanya Pegawai/Pejabat saja.
     */
    protected $fillable = [
        'name',
        'email',
        'role',
    ];

    /**
     * Menonaktifkan timestamps jika Anda hanya ingin membaca data (Read-Only)
     * dan menghindari error jika struktur timestamps di tabel users berbeda.
     */
    public $timestamps = true;
}