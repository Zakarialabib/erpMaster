<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Support\HasAdvancedFilter;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transfer extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use HasUuid;

    final public const ATTRIBUTES = [
        'id',
        'reference',
        'from_warehouse_id',
        'to_warehouse_id',
        'total_qty',
        'total_tax',
        'total_cost',
        'total_amount',
        'shipping',
        'status',
        'note',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'reference',
        'from_warehouse_id',
        'to_warehouse_id',
        'total_qty',
        'total_cost',
        'total_amount',
        'date',
        'shipping_amount',
        'document',
        'status',
        'note',
    ];

    public function fromWarehouse(): BelongsTo
    {
        return $this->belongsTo(
            related: Warehouse::class,
            foreignKey: 'from_warehouse_id',
        );
    }

    public function toWarehouse(): BelongsTo
    {
        return $this->belongsTo(
            related: Warehouse::class,
            foreignKey: 'to_warehouse_id',
        );
    }

    public function transferDetails(): HasMany
    {
        return $this->hasMany(TransferDetail::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }
}
