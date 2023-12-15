<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ShippingStatus;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasUuid;

    final public const ATTRIBUTES = [
        'id', 'date', 'reference',  'shipping_id',
        'total_amount', 'payment_date', 'status', 'payment_status',
        'payment_method', 'shipping_status',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'date',
        'reference',
        'shipping_id',
        'customer_id',
        'user_id',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'payment_date',
        'payment_method',
        'payment_status',
        'shipping_status',
        'status',
        'document',
        'note',
    ];

    protected $casts = [
        'status'          => OrderStatus::class,
        'shipping_status' => ShippingStatus::class,
        'payment_status'  => PaymentStatus::class,
    ];

    public static function generateReference(): string
    {
        $lastOrder = self::latest()->first();

        $number = $lastOrder ? (int) substr((string) $lastOrder->reference, -6) + 1 : 1;

        return date('Ymd').'-'.sprintf('%06d', $number);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }
    
    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            related: Customer::class,
            foreignKey: 'customer_id',
        );
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(orderDetails::class);
    }

    /** get shipping amount */
    protected function shippingAmount(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
        );
    }

    /** get total amount */
    protected function totalAmount(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
        );
    }
}
