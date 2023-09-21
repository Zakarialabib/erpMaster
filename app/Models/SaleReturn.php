<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\SaleReturnStatus;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleReturn extends Model
{
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id',
        'date',
        'reference',
        'tax_percentage',
        'tax_amount',
        'discount_percentage',
        'discount_amount',
        'shipping_amount',
        'total_amount',
        'paid_amount',
        'due_amount',
        'status',
        'payment_status',
        'payment_method',
        'customer_id',

    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'reference',
        'customer_id',
        'user_id',
        'warehouse_id',
        'tax_percentage',
        'tax_amount',
        'discount_percentage',
        'discount_amount',
        'shipping_amount',
        'total_amount',
        'paid_amount',
        'due_amount',
        'status',
        'payment_status',
        'payment_method',
        'note',
        'customer_id',
    ];

    protected $casts = [
        'status'         => SaleReturnStatus::class,
        'payment_status' => PaymentStatus::class,
    ];

    /** @return HasMany<SaleReturnDetail> */
    public function saleReturnDetails(): HasMany
    {
        return $this->hasMany(SaleReturnDetail::class, 'sale_return_id', 'id');
    }

    /** @return HasMany<SaleReturnPayment> */
    public function saleReturnPayments(): HasMany
    {
        return $this->hasMany(SaleReturnPayment::class, 'sale_return_id', 'id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            related: Customer::class,
            foreignKey: 'customer_id',
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(static function ($saleReturn): void {
            $prefix = settings('saleReturn_prefix');
            $latestSaleReturn = self::latest()->first();
            $number = $latestSaleReturn ? (int) substr((string) $latestSaleReturn->reference, -3) + 1 : 1;
            $saleReturn->reference = $prefix.str_pad((string) $number, 3, '0', STR_PAD_LEFT);
        });
    }

    /** @return mixed */
    public function scopeCompleted(mixed $query)
    {
        return $query->whereStatus(2);
    }

    /** get shipping amount */
    protected function shippingAmount(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
        );
    }

    /** get paid amount */
    protected function paidAmount(): Attribute
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

    /** get due amount */
    protected function dueAmount(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
        );
    }

    /** get tax amount */
    protected function taxAmount(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
        );
    }

    /** get discount amount */
    protected function discountAmount(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
        );
    }
}
