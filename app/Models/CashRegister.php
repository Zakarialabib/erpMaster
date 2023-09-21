<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\HasAdvancedFilter;

class CashRegister extends Model
{
    use HasAdvancedFilter;

    /** @var array<int, string> */
    final public const ATTRIBUTES = [
        'id', 'cash_in_hand', 'user_id', 'warehouse_id', 'status',

    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    /** @var array<int, string> */
    protected $fillable = [
        'cash_in_hand', 'user_id', 'warehouse_id', 'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
