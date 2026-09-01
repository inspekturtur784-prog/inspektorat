<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Bikin 1 akun Admin pertama supaya bisa login ke /admin.
 *
 * PENTING: setelah login pertama kali, SEGERA ganti kata sandi ini
 * lewat halaman "Ganti Kata Sandi" di panel Admin — jangan dipakai
 * terus-terusan, apalagi kalau website sudah online (bukan cuma di
 * laptop sendiri).
 *
 * NOTE: password ditulis polos (bukan Hash::make()) karena Model
 * User.php sudah punya cast 'password' => 'hashed', yang otomatis
 * meng-hash sekali saat disimpan. Kalau di sini dipanggil Hash::make()
 * lagi, passwordnya jadi ke-hash DUA KALI dan login akan selalu gagal.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@inspektorat.local'],
            [
                'name' => 'Admin Inspektorat',
                'password' => 'inspektorat123',
                'email_verified_at' => now(),
            ]
        );
    }
}