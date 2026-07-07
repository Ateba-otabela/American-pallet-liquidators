<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatConversation extends Model
{
    protected $fillable = [
        'session_id', 'user_id', 'customer_name', 'customer_email',
        'status', 'assigned_admin_id', 'ai_active', 'needs_admin', 'last_activity'
    ];

    protected $casts = [
        'ai_active' => 'boolean',
        'needs_admin' => 'boolean',
        'last_activity' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'assigned_admin_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
