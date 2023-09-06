<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Enums\Status;

class Category extends Model
{
    use HasAdvancedFilter;
    use HasFactory;

    /** @var array<int, string> */
    public const ATTRIBUTES = [
        'id', 'code', 'name', 'status',
    ];

    public $orderable = self::ATTRIBUTES;
    public $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code', 'name', 'description', 'slug', 'image', 'status',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function __construct(array $attributes = [])
    {
        $this->setRawAttributes([
            'code' => Str::random(8),
        ], true);
        parent::__construct($attributes);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /** @return HasMany<Product> */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
