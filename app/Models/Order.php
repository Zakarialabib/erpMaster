<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;

    final public const ATTRIBUTES = [
        'id', 'date', 'reference',
        'total_amount', 'paid_amount', 'due_amount',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'id', 'date', 'reference', 'shipping_id', 'packaging_id',
         'tax_percentage', 'tax_amount', 'discount_percentage', 'discount_amount', 
         'shipping_amount', 'total_amount', 'paid_amount', 'due_amount', 'payment_date', '
         status', 'payment_status', 'payment_method', 'shipping_status', 'document', 'note',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public static function generateReference(): string
    {
        $lastOrder = self::latest()->first();

        $number = $lastOrder ? (int) substr((string) $lastOrder->reference, -6) + 1 : 1;

        return date('Ymd').'-'.sprintf('%06d', $number);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function packaging(): BelongsTo
    {
        return $this->belongsTo(Packaging::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('qty', 'price', 'tax', 'total');
    }
}
