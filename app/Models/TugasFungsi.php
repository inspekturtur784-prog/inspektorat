<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasFungsi extends Model
{
    protected $fillable = ['judul', 'deskripsi', 'icon', 'urutan'];

    /**
     * Pilihan ikon yang bisa dipilih Admin lewat dropdown (bukan upload SVG
     * bebas, supaya tetap konsisten sama gaya desain situs). Key di sini
     * dipetakan ke path SVG di resources/views/partials/icon.blade.php.
     */
    public const IKON = [
        'kebijakan'    => 'Kebijakan (bar chart)',
        'pengawasan'   => 'Pengawasan (kaca pembesar)',
        'audit'        => 'Audit (perisai)',
        'laporan'      => 'Laporan (dokumen)',
        'administrasi' => 'Administrasi (kotak arsip)',
        'lainnya'      => 'Lainnya (tambah/plus)',
    ];

    public function scopeUrut($query)
    {
        return $query->orderBy('urutan')->orderBy('id');
    }
}