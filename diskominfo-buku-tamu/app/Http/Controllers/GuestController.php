<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;

class GuestController extends Controller
{
    public function index()
    {
        // Langsung tampilkan view tanpa kirim data pejabat
        return view('welcome');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'             => 'required|string|max:255',
            'instansi'         => 'required|string|max:255',
            'jabatan'          => 'nullable|string|max:255',
            'whatsapp'         => 'nullable|string|max:20',
            'pejabat_ditemui'  => 'required|string|max:255', // Kembali ke teks manual
            'tujuan_kunjungan' => 'nullable|string',
            'jam_isi'          => 'nullable|string',
            'swafoto'          => 'nullable|string',
            'tanda_tangan'     => 'required|string',
        ]);

        Guest::create($data);

        return back()->with('success', 'Terima kasih! Data kunjungan Anda telah disimpan.');
    }
}