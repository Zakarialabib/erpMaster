<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class PurchasePayment extends Model
{
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id',
        'purchase_id',
        'payment_method',
        'amount',
        'payment_date',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    protected $guarded = [];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(static function ($purchasePayment): void {
            $prefix = settings('purchasePayment_prefix');
            $latestPurchasePayment = self::latest()->first();
            $number = $latestPurchasePayment ? (int) substr((string) $latestPurchasePayment->reference, -3) + 1 : 1;
            $purchasePayment->reference = $prefix.str_pad((string) $number, 3, '0', STR_PAD_LEFT);
        });
    }

    /** Get ajustement date. */
    public function date(): Attribute
    {
        return Attribute::make(
            get: static fn ($value) => Carbon::parse($value)->format('d M, Y'),
        );
    }

    /** @return mixed */
    public function scopeByPurchase(mixed $query)
    {
        return $query->wherePurchaseId(request()->route('purchase_id'));
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
            set: static fn ($value): int|float => $value * 100,
        );
    }
}
