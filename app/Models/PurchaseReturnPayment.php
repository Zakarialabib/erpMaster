<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class PurchaseReturnPayment extends Model
{
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id',
        'date',
        'reference',
        'amount',
        'note',
        'purchase_return_id',
        'payment_method',
        'created_at',
        'updated_at',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    protected $guarded = [];

    public function purchaseReturn(): BelongsTo
    {
        return $this->belongsTo(PurchaseReturn::class, 'purchase_return_id', 'id');
    }

    public function date(): Attribute
    {
        return Attribute::make(
            get: static fn ($value) => Carbon::parse($value)->format('d M, Y'),
        );
    }

    /** @return mixed */
    public function scopeByPurchaseReturn(mixed $query)
    {
        return $query->wherePurchaseReturnId(request()->route('purchase_return_id'));
    }

    /** Interact with the expenses amount */
    protected function amount(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
            set: static fn ($value): int|float => $value * 100,
        );
    }
}
