<?php

namespace App\Http\Controllers;

use App\Models\InformasiDokumen;

class InformasiController extends Controller
{
    /**
     * Peta slug di URL -> label halaman & nama kategori persis
     * seperti yang diketik di Admin saat menambah dokumen.
     */
    private const PETA_KATEGORI = [
        'sop' => [
            'label' => 'Standar Operasional Prosedur (SOP)',
            'kategori' => 'SOP',
        ],
        'berkala' => [
            'label' => 'Informasi Berkala',
            'kategori' => 'Informasi Berkala',
        ],
        'setiap-saat' => [
            'label' => 'Informasi Setiap Saat',
            'kategori' => 'Informasi Setiap Saat',
        ],
        'ikm' => [
            'label' => 'Indeks Kepuasan Masyarakat (IKM)',
            'kategori' => 'IKM',
        ],
        'persepsi-korupsi' => [
            'label' => 'Persepsi Korupsi',
            'kategori' => 'Persepsi Korupsi',
        ],
    ];

    public function show(string $slug)
    {
        abort_unless(isset(self::PETA_KATEGORI[$slug]), 404);

        $info = self::PETA_KATEGORI[$slug];

        $items = InformasiDokumen::kategori($info['kategori'])->urut()->get();

        return view('informasi.show', [
            'judulHalaman' => $info['label'],
            'items' => $items,
        ]);
    }
}