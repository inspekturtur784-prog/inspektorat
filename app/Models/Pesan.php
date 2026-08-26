<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $fillable = ['nama', 'email', 'telepon', 'pesan', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function scopeTerbaru($query)
    {
        return $query->orderByDesc('created_at');
    }
}