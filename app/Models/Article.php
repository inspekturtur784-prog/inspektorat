<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'category',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published'  => 'boolean',
        'published_at'  => 'datetime',
    ];

    /**
     * Buat slug otomatis dari title kalau belum diisi manual.
     */
    protected static function booted(): void
    {
        static::saving(function (Article $article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title) . '-' . Str::random(5);
            }
        });
    }

    /** Hanya artikel yang sudah dipublish, terbaru dulu. */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->orderByDesc('published_at');
    }

    /** URL gambar cover, fallback ke placeholder kalau kosong. */
    public function getCoverUrlAttribute(): string
    {
        return $this->cover_image
            ? asset('images/articles/' . $this->cover_image)
            : asset('images/articles/placeholder.png');
    }

    /** Tanggal format Indonesia, mis. "18 Agustus 2026". */
    public function getTanggalIndoAttribute(): string
    {
        $bulan = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
            7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
        ];
        $tgl = $this->published_at ?? $this->created_at;
        return $tgl->day . ' ' . $bulan[$tgl->month] . ' ' . $tgl->year;
    }
}