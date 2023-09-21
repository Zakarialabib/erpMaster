<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\HasAdvancedFilter;

class Contact extends Model
{
    use HasFactory;

    use HasAdvancedFilter;

    /** @var array<int, string> */

    final public const ATTRIBUTES = [
        'id',
        'name',
        'email',
        'phone_number',
        'status',
        'subject',
        'type',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'message',
        'status',
        'subject',
        'type',
    ];
}
