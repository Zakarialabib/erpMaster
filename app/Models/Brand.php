<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasAdvancedFilter;
    use HasFactory;

    /** @var array<int, string> */
    final public const ATTRIBUTES = [
        'id', 'name', 'slug', 'status',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', 'name', 'image', 'slug',
        'description', 'status',
        'meta_title', 'meta_description', 'origin',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
