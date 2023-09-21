<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id',
        'category_id',
        'date',
        'reference',
        'amount',
        'created_at',
        'updated_at',
    ];

    public array $orderable = self::ATTRIBUTES;

    public array $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'user_id',
        'warehouse_id',
        'date',
        'reference',
        'description',
        'amount',
    ];

    public function __construct(array $attributes = [])
    {
        $this->setRawAttributes([
            'reference' => 'EXP-'.Carbon::now()->format('d/m/Y'),
            'date'      => Carbon::now()->format('d/m/Y'),
        ], true);
        parent::__construct($attributes);
    }

    /** @return BelongsTo<ExpenseCategory> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            related: ExpenseCategory::class,
            foreignKey: 'category_id'
        );
    }

    /** @return BelongsTo<User> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related : User::class,
            foreignKey : 'user_id'
        );
    }

    /** @return BelongsTo<Warehouse> */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(
            related: Warehouse::class,
            foreignKey: 'warehouse_id',
        );
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
