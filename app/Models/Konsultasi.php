<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $fillable = [
        'nomor_tiket',
        'nama',
        'email',
        'no_wa',
        'instansi',
        'kategori',
        'pertanyaan',
        'jawaban',
        'status',
    ];
}