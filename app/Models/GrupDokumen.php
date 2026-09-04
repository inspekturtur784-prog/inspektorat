<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupDokumen extends Model
{
    protected $fillable = ['subkategori_id', 'nama', 'slug'];

    public function subkategori()
    {
        return $this->belongsTo(Subkategori::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }
}