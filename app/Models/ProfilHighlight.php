<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilHighlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'icon',
        'urutan',
    ];

    /** Urut sesuai kolom 'urutan', lalu terlama dulu kalau nilainya sama. */
    public function scopeUrut($query)
    {
        return $query->orderBy('urutan')->orderBy('id');
    }
}