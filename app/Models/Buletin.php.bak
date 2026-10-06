<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Buletin extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'label', 'title', 'cover_image', 'pdf_file', 'image_position', 'theme',
        'read_minutes', 'intro',
        'toc', 'art_kicker', 'art_title', 'art_p1', 'art_pull', 'art_p2',
        'stats_title', 'stats', 'stats_note',
        'iv_title', 'iv_q', 'iv_a', 'iv_who',
        'is_published', 'published_at',
    ];

    protected $casts = [
        'toc'           => 'array',
        'stats'         => 'array',
        'is_published'  => 'boolean',
        'published_at'  => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Buletin $buletin) {
            if (empty($buletin->slug)) {
                $buletin->slug = Str::slug($buletin->title) . '-' . Str::random(5);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderByDesc('published_at');
    }

    public function getCoverUrlAttribute(): string
    {
        return $this->cover_image
            ? asset('images/buletin/' . $this->cover_image)
            : asset('images/buletin/placeholder.png');
    }

    /** URL file PDF buletin, untuk ditampilkan di flipbook. */
    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf_file
            ? asset('buletin-pdf/' . $this->pdf_file)
            : null;
    }

    public function getImagePositionCssAttribute(): string
    {
        return match ($this->image_position) {
            'top'    => 'top',
            'bottom' => 'bottom',
            default  => 'center',
        };
    }

    public function getThemeColorAttribute(): string
    {
        return match ($this->theme) {
            'brass'  => '#b08d57',
            'rust'   => '#a5462f',
            'forest' => '#2f4a3c',
            default  => '#0f2139',
        };
    }
}