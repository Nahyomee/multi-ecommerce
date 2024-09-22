<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    use HasFactory;

    protected $with = ['active_items'];

    protected $fillable = ['product_id', 'name', 'status'];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function items() : HasMany
    {
        return $this->hasMany(ProductVariantItem::class);
    }

    public function active_items() : HasMany
    {
        return $this->hasMany(ProductVariantItem::class)->where('status', 1);
    }

    /**
     * Scope a query to only include active variants.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
    
}
