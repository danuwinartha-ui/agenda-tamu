<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;
use App\Models\Guest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| IN-TOUCH Route Configuration (Monthly Logic Update)
|--------------------------------------------------------------------------
*/

Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::post('/store', [GuestController::class, 'store'])->name('guest.store');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/admin', function (Request $request) {
        $query = Guest::query();

        if ($request->filled('tanggal')) {
            // Jika memilih tanggal spesifik
            $query->whereDate('created_at', $request->tanggal);
            $filterInfo = "Laporan Tanggal: " . date('d-m-Y', strtotime($request->tanggal));
        } else {
            // JIKA KOSONG / CLEAR: Tampilkan data BULAN INI (This Month)
            $query->whereMonth('created_at', date('m'))
                  ->whereYear('created_at', date('Y'));
            $filterInfo = "Laporan Bulan Berjalan: " . date('F Y');
        }

        $guests = $query->latest()->get();
        return view('admin', compact('guests', 'filterInfo'));
    })->name('admin.dashboard');

});