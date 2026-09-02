<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PengaturanProfil extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Ambil satu nilai pengaturan berdasarkan key.
     * Dipakai di halaman Profil supaya kontennya diambil dari database,
     * bukan ditulis langsung di kode.
     */
    public static function get(string $key, string $default = ''): string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /** Simpan/update satu nilai pengaturan. */
    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /** Ambil semua pengaturan sekaligus sebagai array [key => value]. */
    public static function semua(): array
    {
        return static::pluck('value', 'key')->toArray();
    }
}