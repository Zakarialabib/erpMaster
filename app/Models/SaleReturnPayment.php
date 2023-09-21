<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class SaleReturnPayment extends Model
{
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id',
        'sale_return_id',
        'amount',
        'payment_method',
        'created_at',
        'updated_at',

    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    protected $guarded = [];

    public function saleReturn(): BelongsTo
    {
        return $this->belongsTo(SaleReturn::class, 'sale_return_id', 'id');
    }

    /** Get ajustement date. */
    public function date(): Attribute
    {
        return Attribute::make(
            get: static fn ($value) => Carbon::parse($value)->format('d M, Y'),
        );
    }

    /** @return mixed */
    public function scopeBySaleReturn(mixed $query)
    {
        return $query->whereSaleReturnId(request()->route('sale_return_id'));
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
