<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Subkategori;
use App\Models\PedomanDokumen;
use App\Models\PedomanKategori;

class KmsDokumenListController extends Controller
{
    public function index()
    {
        $kms = Dokumen::with(['kategori', 'subkategori'])->get()->map(function ($d) {
            return [
                'judul'     => $d->judul,
                'sumber'    => 'KMS',
                'kategori'  => ($d->kategori->nama ?? '-') . ' / ' . ($d->subkategori->nama ?? '-'),
                'tipe'      => $d->file_type,
                'file_url'  => url('/files/' . $d->file_path),
                'edit_url'  => route('admin.kms.dokumen.edit', $d),
                'hapus_url' => route('admin.kms.dokumen.destroy', $d),
                'ts'        => optional($d->created_at)->timestamp ?? 0,
            ];
        });

        $pedoman = PedomanDokumen::with('kategori')->get()->map(function ($d) {
            return [
                'judul'     => $d->judul,
                'sumber'    => 'Pedoman',
                'kategori'  => $d->kategori->nama ?? '-',
                'tipe'      => $d->file_type,
                'file_url'  => url('/files/' . $d->file_path),
                'edit_url'  => route('admin.pedoman.dokumen.edit', $d),
                'hapus_url' => route('admin.pedoman.dokumen.destroy', $d),
                'ts'        => optional($d->created_at)->timestamp ?? 0,
            ];
        });

        $rows = $kms->concat($pedoman)->sortByDesc('ts')->values();
        $subkategoris = Subkategori::with('kategori')->orderBy('nama')->get();
        $pedomanKategoris = PedomanKategori::orderBy('nama')->get();

        return view('admin.kms-pedoman.dokumen', compact('rows', 'subkategoris', 'pedomanKategoris'));
    }
}