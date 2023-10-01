<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OrderDetails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'warehouse_id',
        'name',
        'code',
        'quantity',
        'price',
        'unit_price',
        'sub_total',
        'product_discount_amount',
        'product_discount_type',
        'product_tax_amount',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
            set: static fn ($value): int|float => $value * 100,
        );
    }


    /** Interact with unit price */
    protected function unitPrice(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
        );
    }

    /** get subtotal attribute */
    protected function subTotal(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
        );
    }

    /** product discount amount attribute */
    protected function productDiscountAmount(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
        );
    }

    /** Interact with shipping amount */
    protected function productTaxAmount(): Attribute
    {
        return Attribute::make(
            get: static fn ($value): int|float => $value / 100,
        );
    }
}
