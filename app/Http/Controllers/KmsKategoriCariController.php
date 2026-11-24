<?php

namespace App\Http\Controllers;

use App\Models\Kategori;

class KmsKategoriCariController extends KmsController
{
    public function kategori($slug)
    {
        $cari = trim((string) request('cari'));
        $pola = '%' . str_replace(['%', '_'], ['\%', '\_'], $cari) . '%';
        $saring = fn ($q) => $cari !== '' ? $q->where('judul', 'like', $pola) : $q;

        $kategori = Kategori::where('slug', $slug)
            ->with([
                'subkategoris.dokumensLangsung' => $saring,
                'subkategoris.grupDokumens.dokumens' => $saring,
            ])
            ->firstOrFail();

        if ($cari !== '') {
            foreach ($kategori->subkategoris as $s) {
                $s->setRelation('grupDokumens', $s->grupDokumens->filter(fn ($g) => $g->dokumens->isNotEmpty())->values());
            }
            $kategori->setRelation('subkategoris', $kategori->subkategoris->filter(
                fn ($s) => $s->dokumensLangsung->isNotEmpty() || $s->grupDokumens->isNotEmpty()
            )->values());
        }

        return view('kms.kategori', compact('kategori'));
    }
}