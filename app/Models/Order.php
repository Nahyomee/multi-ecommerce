<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'invoice_id', 'sub_total', 'amount',
                            'currency', 'currency_icon', 'qty', 'payment_method', 'payment_status',
                            'coupon','shipping_method', 'shipping_address', 'status'                    
                        ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items() : HasMany
    {
        return $this->hasMany(OrderDetails::class);
    }

    
    public function transaction() : HasOne
    {
        return $this->hasOne(Transaction::class);
    }

                    
}
