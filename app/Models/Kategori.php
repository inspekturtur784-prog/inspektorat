<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'slug'];

    public function subkategoris()
    {
        return $this->hasMany(Subkategori::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }
}