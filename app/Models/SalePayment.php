<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class SalePayment extends Model
{
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id',
        'sale_id',
        'payment_method',
        'reference',
        'amount',
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
        'amount',
        'note',
        'sale_id',
        'payment_method',
        'user_id',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }

    /** Get ajustement date. */
    public function date(): Attribute
    {
        return Attribute::make(
            get: static fn ($value) => Carbon::parse($value)->format('d M, Y'),
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(static function ($salePayment): void {
            $prefix = settings('salePayment_prefix');
            $latestSalePayment = self::latest()->first();
            $number = $latestSalePayment ? (int) substr((string) $latestSalePayment->reference, -3) + 1 : 1;
            $salePayment->reference = $prefix.str_pad((string) $number, 3, '0', STR_PAD_LEFT);
        });
    }

    /** @return mixed */
    public function scopeBySale(mixed $query)
    {
        return $query->whereSaleId(request()->route('sale_id'));
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
