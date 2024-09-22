<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetails extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'vendor_id', 'product_name', 'unit_price', 
                            'quantity', 'variants', 'variant_total'];

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class);
    }


    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

}
