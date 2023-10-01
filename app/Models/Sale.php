<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\SaleStatus;
use App\Scopes\SaleScope;
use App\Support\HasAdvancedFilter;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasAdvancedFilter;
    use SaleScope;
    use HasUuid;

    final public const ATTRIBUTES = [
        'id',
        'date',
        'reference',
        'customer_id',
        'warehouse_id',
        'tax_percentage',
        'tax_amount',
        'discount_percentage',
        'discount_amount',
        'shipping_amount',
        'total_amount',
        'payment_date',
        'paid_amount',
        'due_amount',
        'status',
        'payment_status',
        'payment_method',
        'shipping_status',
        'created_at',
        'updated_at',

    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'date',
        'reference',
        'customer_id',
        'user_id',
        'warehouse_id',
        'cash_register_id',
        'tax_percentage',
        'tax_amount',
        'payment_date',
        'discount_percentage',
        'discount_amount',
        'shipping_amount',
        'total_amount',
        'paid_amount',
        'due_amount',
        'status',
        'payment_status',
        'payment_method',
        'shipping_status',
        'note',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status'         => SaleStatus::class,
        'payment_status' => PaymentStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(static function ($sale): void {
            $prefix = settings('sale_prefix');
            $latestSale = self::latest()->first();
            $number = $latestSale ? (int) substr((string) $latestSale->reference, -3) + 1 : 1;
            $sale->reference = $prefix.str_pad((string) $number, 3, '0', STR_PAD_LEFT);
        });
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(
            related: Warehouse::class,
            foreignKey: 'warehouse_id'
        );
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetails::class);
    }

    public function salePayments(): HasMany
    {
        return $this->hasMany(SalePayment::class, 'sale_id', 'id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            related: Customer::class,
            foreignKey: 'customer_id',
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    public function scopeCompleted($query)
    {
        return $query->whereStatus(SaleStatus::COMPLETED);
    }

    public function scopeReturned($query)
    {
        return $query->whereStatus(SaleStatus::RETURNED);
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
