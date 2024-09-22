<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'quantity', 'max_use', 'start_date', 'end_date', 
                            'discount_type', 'discount_value', 'status', 'total_used'];
}
