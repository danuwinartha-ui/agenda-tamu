<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Super Admin Diskominfo',
            'email'    => 'admin@karangasem.go.id',
            'password' => Hash::make('Survival-Freeway-Composite5'),
            'role'     => 'admin', // Sesuaikan jika ada kolom role di tabel users Anda
        ]);
    }
}