<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'category_id', 'subcategory_id', 'child_category_id', 'brand_id',
            'name', 'slug', 'thumb_img', 'quantity', 'price', 'short_desc', 'description', 'video_link',
            'sku', 'offer_price', 'offer_start', 'offer_end', 'product_type',
            'is_approved', 'status', 'seo_title', 'seo_description' 
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory() : BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function childcategory() : BelongsTo
    {
        return $this->belongsTo(ChildCategory::class, 'child_category_id');
    }

    public function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images() : HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants() : HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function active_variants() : HasMany
    {
        return $this->hasMany(ProductVariant::class)->where('status', 1);
    }


     /**
     * Scope a query to only include approved products.
     */
    public function scopeApproved(Builder $query): void
    {
        $query->where('is_approved', 1);
    }
 
    /**
     * Scope a query to only include active products.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

     /**
     * Attribute to check if there's discount
     */
    public function getHasDiscountAttribute()
    {
        $date = Carbon::today();
        //check if date is between offer start and end
        if($date->between($this->offer_start, $this->offer_end) && $this->offer_price > 0){
            return true;
        }
        return false;
    }

    /**
     * Attribute for discount
     */
    public function getDiscountAttribute()
    {
        $date = Carbon::today();
        //check if date is between offer start and end
        if($date->between($this->offer_start, $this->offer_end) && $this->offer_price > 0){
            return $this->offer_price;
        }
        return $this->price;
    }

    /**
     * Calculate discount percentage 
    */
    public function getDiscountPercentageAttribute()
    {
        if($this->hasDiscount){
            $percent  = (($this->price - $this->offer_price) / $this->price) * 100;
            return number_format($percent);
        }
        return 0;
    }

    /**
     * Get product type
     */
    public function getTypeAttribute()
    {
        switch ($this->product_type) {
            case 'new arrival':
                return "New";
                break;
            case 'featured product':
                return "Featured";
                break;
            case 'top product':
                return "Top";
                break;
            case 'best product':
                return "Best";
                break;
            default:
                return "";
                break;
        }
    }
}

