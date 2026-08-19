<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreightQuote extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'email',
        'phone',
        'product_id',
        'quantity',
        'destination_zip',
        'delivery_type',
        'has_loading_dock',
        'notes',
        'status'
    ];

    protected $casts = [
        'has_loading_dock' => 'boolean',
        'quantity' => 'integer',
    ];

    /**
     * Get the product associated with this quote request.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
