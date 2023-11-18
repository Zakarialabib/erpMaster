<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use App\Trait\GetModelByUuid;
use App\Trait\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use UuidGenerator;
    use GetModelByUuid;

    public const ATTRIBUTES = [
        'id',
        'status',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $orderable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'price',
        'features',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status'   => 'boolean',
        'features' => 'array',
    ];
}
