<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaystackSetting extends Model
{
    use HasFactory;

    protected $fillable = ['currency', 'rate', 'public_key', 'secret_key', 'merchant_email'];
}
