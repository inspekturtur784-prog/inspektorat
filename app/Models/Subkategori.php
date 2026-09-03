<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subkategori extends Model
{
    use HasFactory;

    protected $fillable = ['kategori_id', 'nama', 'slug'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function grupDokumens()
    {
        return $this->hasMany(GrupDokumen::class);
    }

    public function dokumensLangsung()
    {
        return $this->hasMany(Dokumen::class)->whereNull('grup_dokumen_id');
    }
}