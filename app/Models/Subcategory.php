<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    use HasAdvancedFilter;

    /** @var array<int, string> */
    final public const ATTRIBUTES = [
        'id', 'category_id', 'name', 'slug', 'language_id',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'category_id', 'name', 'slug', 'language_id',
    ];

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     */
    public function scopeActive($query): void
    {
        $query->where('status', 1);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            related: Category::class,
            foreignKey: 'category_id'
        );
    }

    /** @return HasMany<Product> */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = str_replace(' ', '-', (string) $value);
    }
}
