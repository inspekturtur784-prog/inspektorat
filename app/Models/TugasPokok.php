<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasPokok extends Model
{
    protected $table = 'tugas_pokok';

    protected $fillable = ['teks', 'urutan'];

    public function scopeUrut($query)
    {
        return $query->orderBy('urutan')->orderBy('id');
    }
}