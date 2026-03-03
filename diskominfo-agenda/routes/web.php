<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;


Route::get('/', [AgendaController::class, 'index'])->name('login');

// ROUTE KHUSUS UNTUK AUTO REFRESH
Route::get('/check-update', [AgendaController::class, 'checkUpdate'])->name('check.update');

// LOGIN PROSES
Route::post('/login-proses', [AgendaController::class, 'login'])->name('login.submit');

// AREA ADMIN
Route::middleware(['auth'])->group(function () {
    
    // DASHBOARD
    Route::get('/dashboard', [AgendaController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/panel', [AgendaController::class, 'dashboard'])->name('dashboard');

    // CRUD AGENDA
    Route::post('/agenda/store', [AgendaController::class, 'addAgenda'])->name('agenda.store');
    Route::post('/agenda/update/{id}', [AgendaController::class, 'updateAgenda'])->name('agenda.update');
    Route::get('/agenda/delete/{id}', [AgendaController::class, 'deleteAgenda'])->name('agenda.delete');
    Route::get('/agenda/toggle/{id}', [AgendaController::class, 'toggleStatus'])->name('agenda.toggle');

    // CETAK LAPORAN
    Route::get('/laporan/cetak', [AgendaController::class, 'generateLaporan'])->name('admin.generate-laporan');

    // PASSWORD & USER
    Route::get('/password/edit', [AgendaController::class, 'editPassword'])->name('password.edit');
    Route::post('/password/update', [AgendaController::class, 'updatePassword'])->name('password.update');
    Route::post('/user/add', [AgendaController::class, 'addUser'])->name('admin.add-user');
    Route::post('/user/reset-password/{id}', [AgendaController::class, 'resetUserPassword'])->name('admin.reset-user-password');
    Route::get('/user/delete/{id}', [AgendaController::class, 'deleteUser'])->name('admin.delete-user');

    // LOGOUT
    Route::post('/logout', [AgendaController::class, 'logout'])->name('logout');
});