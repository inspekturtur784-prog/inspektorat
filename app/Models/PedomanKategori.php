<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedomanKategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'slug'];

    public function dokumens()
    {
        return $this->hasMany(PedomanDokumen::class);
    }
}