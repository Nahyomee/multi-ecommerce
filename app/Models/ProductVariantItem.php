<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariantItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_variant_id', 'name', 'price', 'is_default', 'status'];

    public function variant() : BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Scope a query to only include active variants.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
}
