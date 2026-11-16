<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveChatThread extends Model
{
    protected $table = 'livechat_threads';

    protected $fillable = [
        'token', 'nama', 'email', 'telepon', 'status',
        'last_message_at', 'admin_last_read_at',
    ];

    protected $casts = [
        'last_message_at'    => 'datetime',
        'admin_last_read_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(LiveChatMessage::class, 'thread_id')->orderBy('id');
    }
}