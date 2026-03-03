<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model {
    protected $fillable = [
        'nama', 'instansi', 'jabatan', 'whatsapp', 
        'pejabat_ditemui', 'tujuan_kunjungan', 'jam_isi', 'swafoto', 'tanda_tangan'
    ];
}