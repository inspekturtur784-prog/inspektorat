<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'golongan',
        'bidang',
        'tugas',
        'fungsi',
        'photo',
        'urutan',
    ];

    /** Urutkan sesuai kolom "urutan" (mis. Inspektur paling atas), lalu nama. */
    public function scopeUrut($query)
    {
        return $query->orderBy('urutan')->orderBy('nama');
    }

    /** URL foto pegawai, fallback ke avatar placeholder kalau kosong. */
    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('images/pegawai/' . $this->photo)
            : asset('images/pegawai/placeholder.png');
    }
}