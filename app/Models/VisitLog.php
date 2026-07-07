<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'device_type',
        'os',
        'browser',
        'path',
        'location',
        'chat_session_id',
        'chat_question'
    ];
}
