<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedomanDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedoman_kategori_id',
        'judul',
        'deskripsi',
        'file_path',
        'file_type',
        'ukuran_kb',
        'downloads',
    ];

    public function kategori()
    {
        return $this->belongsTo(PedomanKategori::class, 'pedoman_kategori_id');
    }

    // Biar bisa ditulis $dokumen->ukuran (otomatis convert KB ke MB kalau perlu)
    public function getUkuranAttribute()
    {
        $kb = $this->ukuran_kb;
        if ($kb >= 1024) {
            return round($kb / 1024, 2) . ' MB';
        }
        return $kb . ' KB';
    }
}