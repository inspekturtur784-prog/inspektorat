<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InformasiDokumen extends Model
{
    use HasFactory;

    protected $table = 'informasi_dokumens';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'urutan',
        'keterangan',
        'file',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public const KATEGORI_SARAN = [
        'SOP',
        'Informasi Berkala',
        'Informasi Setiap Saat',
        'IKM',
        'Persepsi Korupsi',
    ];

    protected static function booted(): void
    {
        static::saving(function (InformasiDokumen $dokumen) {
            if (empty($dokumen->slug)) {
                $dokumen->slug = Str::slug($dokumen->judul) . '-' . Str::random(5);
            }
        });
    }

    public function scopeKategori($query, ?string $kategori)
    {
        return $kategori ? $query->where('kategori', $kategori) : $query;
    }

    public function scopeUrut($query)
    {
        return $query->orderBy('urutan')->orderBy('judul');
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file ? Storage::url($this->file) : null;
    }
}
