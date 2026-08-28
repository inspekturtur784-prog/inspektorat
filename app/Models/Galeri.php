<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'tanggal',
        'deskripsi',
        'foto',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Daftar SARAN kategori (ditampilkan sebagai datalist di form Admin).
     */
    public const KATEGORI_SARAN = ['Kegiatan', 'Sosialisasi', 'Pengawasan', 'Rapat', 'Dokumentasi'];

    // Menambahkan alias KATEGORI agar controller tidak memicu Undefined Constant Error
    public const KATEGORI = self::KATEGORI_SARAN;

    protected static function booted(): void
    {
        static::saving(function (Galeri $galeri) {
            if (empty($galeri->slug)) {
                $galeri->slug = Str::slug($galeri->judul) . '-' . Str::random(5);
            }
        });
    }

    public function scopeKategori($query, ?string $kategori)
    {
        return $kategori ? $query->where('kategori', $kategori) : $query;
    }

    public function scopeTerbaru($query)
    {
        return $query->orderByDesc('tanggal');
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return Storage::url($this->foto);
        }

        return asset('images/galeri/placeholder.webp');
    }

    public function getTanggalIndoAttribute(): string
    {
        if (!$this->tanggal) {
            return '—';
        }

        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return $this->tanggal->day . ' ' . $bulan[$this->tanggal->month] . ' ' . $this->tanggal->year;
    }
}