<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturBagian extends Model
{
    protected $fillable = ['nama', 'jabatan_desc', 'tugas', 'bidang_key', 'is_top', 'urutan'];

    protected $casts = [
        'is_top' => 'boolean',
    ];

    public function scopeUrut($query)
    {
        return $query->orderBy('urutan')->orderBy('id');
    }

    /** Pegawai yang bidangnya cocok dengan bagian ini (buat ditampilkan otomatis). */
    public function getPejabatAttribute()
    {
        if (! $this->bidang_key) {
            return collect();
        }

        return Pegawai::urut()->where('bidang', $this->bidang_key)->get();
    }
}