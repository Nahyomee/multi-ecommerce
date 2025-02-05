<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'banner', 'phone', 'email', 'address', 'description',
        'facebook', 'twitter', 'instagram', 'whatsapp', 'shop_name'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
