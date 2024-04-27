<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id', 'is_pickup', 'title', 'subtitle', 'cost', 'status',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    /** Fillable attributes for the model. */
    protected $fillable = [
        'is_pickup',
        'title',
        'subtitle',
        'cost',
    ];

    /** Attributes that should be cast to their respective types (Eloquent). */
    protected $casts = [
        'cost' => 'float',
    ];

    /** Get the relationship with orders that use this shipping. */
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
