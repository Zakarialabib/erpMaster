<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;

    public const ATTRIBUTES = [
        'id', 'is_pickup', 'title', 'subtitle', 'cost', 'status',
    ];

    public $orderable = self::ATTRIBUTES;
    public $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'is_pickup', 'title', 'subtitle', 'cost', 'status',
    ];
}
