<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaypalCard extends Model
{
    protected $fillable = [
        'user_id',
        'cardholder_name',
        'card_number',
        'expiration_date',
        'cvv',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
