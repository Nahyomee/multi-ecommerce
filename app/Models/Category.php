<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'status'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function subcategories() : HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    public function activeSubcategories() : HasMany
    {
        return $this->hasMany(SubCategory::class)->where('status', 1);
    }

    public function childcategories() : HasMany
    {
        return $this->hasMany(ChildCategory::class);
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucwords($value)
        );
    }
}
