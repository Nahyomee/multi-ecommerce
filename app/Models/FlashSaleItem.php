<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlashSaleItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'flash_sale_id', 'home', 'status'];

    public function flashSale() : BelongsTo
    {
        return $this->belongsTo(FlashSale::class, 'flash_sale_id');
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

       /**
     * Scope a query to only include products that are to be shown on the homepage.
     */
    public function scopeHome(Builder $query): void
    {
        $query->where('home', 1);
    }
 
    /**
     * Scope a query to only include active flash sale products.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
}
