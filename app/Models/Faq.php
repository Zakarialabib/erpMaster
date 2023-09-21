<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\HasAdvancedFilter;

class Faq extends Model
{
    use HasFactory;
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    public array $orderable = self::ATTRIBUTES;

    public array $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'name',
        'description',
    ];
}
