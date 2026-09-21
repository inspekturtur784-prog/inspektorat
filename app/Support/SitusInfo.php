<?php

namespace App\Support;

use App\Models\PengaturanProfil;

/**
 * Info kontak & media sosial untuk footer.
 * Nilai bawaan = isi footer sebelum dibuat dinamis, jadi tampilan tidak berubah
 * sampai admin menyimpan Pengaturan Situs.
 */
class SitusInfo
{
    public static function bawaan(): array
    {
        return [
            'kontak_alamat'      => 'Jl. Benteng Pancasila No. 23, Magersari, Kota Mojokerto, Jawa Timur 61314',
            'kontak_telepon'     => '(0321) 399630',
            'kontak_email'       => 'inspektorat@mojokertokota.go.id',
            'kontak_jam_layanan' => "Senin – Kamis\n07.30 – 15.30 WIB\n\nJumat\n07.30 – 14.30 WIB\n\nSabtu, Minggu & Libur Nasional\nTutup",
            'kontak_maps_embed'  => 'https://www.google.com/maps?q=Jl.+Benteng+Pancasila+No.+23,+Magersari,+Kota+Mojokerto,+Jawa+Timur+61314&output=embed',
            'sosmed_facebook'    => '',
            'sosmed_instagram'   => 'https://www.instagram.com/inspektoratkotamr',
            'sosmed_youtube'     => '',
        ];
    }

    public static function semua(): array
    {
        $hasil = self::bawaan();

        try {
            $tersimpan = PengaturanProfil::semua();
        } catch (\Throwable $e) {
            $tersimpan = [];
        }

        foreach ($hasil as $key => $nilai) {
            if (array_key_exists($key, $tersimpan)) {
                $hasil[$key] = (string) $tersimpan[$key];
            }
        }

        return $hasil;
    }
}