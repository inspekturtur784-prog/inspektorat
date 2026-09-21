<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanProfil;
use Illuminate\Http\Request;

/**
 * Kontak & media sosial website (dipakai footer).
 * Datanya disimpan di tabel pengaturan_profils yang sudah ada (key-value).
 */
class PengaturanSitusController extends Controller
{
    public function edit()
    {
        return view('admin.pengaturan-situs.edit', ['s' => \App\Support\SitusInfo::semua()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'kontak_alamat'      => 'nullable|string|max:500',
            'kontak_telepon'     => 'nullable|string|max:50',
            'kontak_email'       => 'nullable|email|max:150',
            'kontak_jam_layanan' => 'nullable|string|max:255',
            'kontak_maps_embed'  => 'nullable|url|max:1000',
            'sosmed_facebook'    => 'nullable|url|max:255',
            'sosmed_instagram'   => 'nullable|url|max:255',
            'sosmed_youtube'     => 'nullable|url|max:255',
        ]);

        foreach ($data as $key => $value) {
            PengaturanProfil::set($key, $value ?? '');
        }

        return redirect()->route('admin.pengaturan-situs.edit')
            ->with('status_situs', 'Pengaturan situs berhasil disimpan.');
    }
}