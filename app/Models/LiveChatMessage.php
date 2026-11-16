<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveChatMessage extends Model
{
    protected $table = 'livechat_messages';

    protected $fillable = ['thread_id', 'sender', 'admin_id', 'body'];

    public function thread()
    {
        return $this->belongsTo(LiveChatThread::class, 'thread_id');
    }
}