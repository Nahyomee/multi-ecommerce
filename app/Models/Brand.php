<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'slug', 'is_featured', 'status'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
