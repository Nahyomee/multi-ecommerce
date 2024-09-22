<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'transaction_id', 'payment_method', 'amount', 'amount_real_currency', 'amount_real_currency_name'];

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

}
