<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'badge',
        'category_id',
        'stock',
        'images',
        'condition',
        'number_of_units',
        'estimated_retail_value',
        'manifest_url',
        'dimensions',
        'weight',
        'damage_info',
        'testing_info',
        'pickup_location',
        'shipping_info',
        'estimated_shipping_cost',
        'whats_included',
        'whats_not_included',
        'refund_conditions'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'images' => 'array',
        'stock' => 'integer',
        'estimated_retail_value' => 'decimal:2',
        'estimated_shipping_cost' => 'decimal:2',
        'number_of_units' => 'integer',
        'weight' => 'integer',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get first image URL or placeholder.
     */
    public function getFirstImageUrlAttribute(): string
    {
        if (is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }
        return 'https://placehold.co/600x600?text=' . urlencode($this->name);
    }
}
