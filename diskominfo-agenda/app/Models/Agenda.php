<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id', 
    'kegiatan', 
    'perihal', 
    'tanggal', 
    'waktu', 
    'tempat', 
    'dari_instansi', 
    'disposisi', 
    'status'
];

    /**
     * Relasi ke Model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}