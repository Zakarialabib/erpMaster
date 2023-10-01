<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\QuotationStatus;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Quotation extends Model
{
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id',
        'date',
        'reference',
        'customer_id',
        'tax_amount',
        'discount_amount',
        'shipping_amount',
        'total_amount',
        'status',
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
        'status',
        'note',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status' => QuotationStatus::class,
    ];

    public function quotationDetails(): HasMany
    {
        return $this->hasMany(QuotationDetails::class, 'quotation_id', 'id');
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

        static::creating(static function ($quotation): void {
            $prefix = settings('quotation_prefix');
            $latestQuotation = self::latest()->first();
            $number = $latestQuotation ? (int) substr((string) $latestQuotation->reference, -3) + 1 : 1;
            $quotation->reference = $prefix.str_pad((string) $number, 3, '0', STR_PAD_LEFT);
        });
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
