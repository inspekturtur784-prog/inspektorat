<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KmsDocument extends Model
{
    protected $fillable = [
        'kms_category_id',
        'title',
        'tag',
        'file_path',
        'original_name',
        'file_type',
        'views',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(KmsCategory::class, 'kms_category_id');
    }
}