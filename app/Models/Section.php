<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PageType;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id',
        'title',
        'status',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'page_id',
        'title',
        'featured_title',
        'subtitle',
        'text',
        'bg_color',
        'text_color',
        'type',
        'position',
        'label',
        'link',
        'image',
        'description',
        'embeded_video',
        'status',
    ];

    protected $casts = [
        'type'   => PageType::class,
        'satuts' => Status::class,
    ];

    public function scopeActive($query): void
    {
        $query->where('status', true);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
