<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [ 'category_id', 'name', 'slug', 'status'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function childcategories() : HasMany
    {
        return $this->hasMany(ChildCategory::class);
    }

    public function activeChildCategories() : HasMany
    {
        return $this->hasMany(ChildCategory::class)->where('status', 1);
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucwords($value)
        );
    }
}
