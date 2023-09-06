<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasAdvancedFilter;
    use HasFactory;

    /** @var array<int, string> */
    public const ATTRIBUTES = [
        'id',
        'title',
        'slug',
        'status',
        'featured',
        'category_id',
        'language_id',
    ];

    public $orderable = self::ATTRIBUTES;
    public $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'slug',
        'status',
        'featured',
        'category_id',
        'meta_title',
        'meta_description',
        'language_id',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    /** @return BelongsTo<BlogCategory> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /** @return BelongsTo<Language> */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
