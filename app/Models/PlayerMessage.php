<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerMessage extends Model
{
    protected $fillable = ['from_user_id', 'to_user_id', 'subject', 'body', 'is_read', 'read_at'];

    protected $casts = ['read_at' => 'datetime', 'is_read' => 'boolean'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function markRead(): void
    {
        if (!$this->is_read) {
            $this->update(['is_read' => true, 'read_at' => now()]);
        }
    }
}
