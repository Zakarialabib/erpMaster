<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogCategory extends Model
{
    use HasAdvancedFilter;

    /** @var array<int, string> */
    final public const ATTRIBUTES = [
        'id',
        'title',
        'featured',
        'status',
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
        'meta_title',
        'meta_description',
        'featured',
        'status',
        'language_id',
    ];

    /** @return HasMany<Blog> */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = str_replace(' ', '-', (string) $value);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
