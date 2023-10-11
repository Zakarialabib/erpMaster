<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use App\Enums\TaxType;
use App\Scopes\ProductScope;
use App\Support\HasAdvancedFilter;
use App\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasAdvancedFilter;
    use Notifiable;
    use ProductScope;
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    /** @var array<int, string> */
    final public const ATTRIBUTES = [
        'id',
        'category_id',
        'name',
        'code',
        'created_at',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', 'name', 'code', 'barcode_symbology', 'quantity', 'slug',
        'category_id',
        'image', 'gallery', 'unit', 'order_tax', 'description', 'status',
        'tax_type', 'featured', 'usage', 'embeded_video', 'subcategories',
        'options', 'meta_title', 'meta_description', 'best', 'hot',
    ];

    public function __construct(array $attributes = [])
    {
        $this->setRawAttributes([

            'code' => Carbon::now()->format('Y-m-d').mt_rand(10000000, 99999999),

        ], true);
        parent::__construct($attributes);
    }

    protected $casts = [
        'options'       => 'array',
        'subcategories' => 'array',
        'tax_type'  => TaxType::class,
        'status'        => Status::class,
    ];

    public function scopeActive($query): void
    {
        $query->where('status', Status::ACTIVE);
    }

    /** @return BelongsTo<Category> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /** @return BelongsTo<Brand> */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /** @return MorphMany<Movement> */
    public function movements(): MorphMany
    {
        return $this->morphMany(Movement::class, 'movable');
    }

    /** @return BelongsToMany<Warehouse> */
    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class)
            ->withPivot('qty', 'price', 'cost', 'old_price', 'stock_alert', 'is_discount', 'discount_date', 'is_ecommerce');
    }

    public static function ecommerceProducts()
    {
        return static::whereHas('warehouses', static function ($query) : void {
            $query->where('is_ecommerce', 1);
        })->with(['warehouses' => static function ($query) : void {
            $query->select('product_id', 'qty', 'price', 'old_price', 'is_discount', 'discount_date');
        }]);
    }

    public function getTotalQuantityAttribute(): int|float|null
    {
        return $this->warehouses->sum('pivot.qty');
    }

    public function getAveragePriceAttribute(): int|float|null
    {
        return $this->warehouses->avg('pivot.price') / 100;
    }

    public function getAverageCostAttribute(): int|float|null
    {
        return $this->warehouses->avg('pivot.cost') / 100;
    }
}
