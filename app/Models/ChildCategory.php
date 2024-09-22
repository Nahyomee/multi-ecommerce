<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'sub_category_id', 'name', 'slug', 'status'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory() : BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucwords($value)
        );
    }
}
