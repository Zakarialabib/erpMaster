<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\HasAdvancedFilter;
use App\Enums\ShippingStatus;

class Delivery extends Model
{
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id', 'created_at', 'updated_at',  'address',
        'reference', 'sale_id', 'order_id', 'user_id',
    ];

    public array $orderable = self::ATTRIBUTES;

    public array $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'reference', 'sale_id', 'order_id', 'user_id',
        'shipping_id', 'document', 'status', 'note',
        'address',  'delivered_by', 'recieved_by',
    ];

    protected $casts = [
        'status' => ShippingStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(static function ($delivery): void {
            $prefix = settings('delivery_prefix');
            $latestDelivery = self::latest()->first();
            $number = $latestDelivery ? (int) substr((string) $latestDelivery->reference, -3) + 1 : 1;
            $delivery->reference = $prefix.str_pad((string) $number, 3, '0', STR_PAD_LEFT);
        });
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
