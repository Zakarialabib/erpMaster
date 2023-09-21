<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PageType;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasAdvancedFilter;
    use HasFactory;

    final public const ATTRIBUTES = [
        'id', 'title', 'slug',
        'type',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'title', 'slug', 'description',
        'meta_title', 'meta_description',
        'status', 'images', 'type',
        'is_sliders', 'is_contact', 'is_offer',
        'is_workshop_activity', 'is_outdoor_activity',
        'is_package', 'is_partners',
        'is_title', 'is_description',
    ];

    protected $casts = [
        'satuts' => Status::class,
        // 'type'   => PageType::class,
    ];

    public function scopeActive($query): void
    {
        $query->where('status', true);
    }
}
