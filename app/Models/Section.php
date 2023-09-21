<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasAdvancedFilter;

    final public const HOME_PAGE = 1;

    final public const ABOUT_PAGE = 2;

    final public const BRAND_PAGE = 3;

    final public const BLOG_PAGE = 4;

    final public const CATALOG_PAGE = 5;

    final public const BRANDS_PAGE = 6;

    final public const CONTACT_PAGE = 7;

    final public const PRODUCT_PAGE = 8;

    final public const PRIVACY_PAGE = 9;

    public $table = 'sections';

    final public const ATTRIBUTES = [
        'id',
        'featured_title',
        'label',
        'status',
        'subtitle',
        'title',
        'position',
        'page',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'title', 'image', 'featured_title', 'subtitle', 'label', 'link', 'description', 'status', 'bg_color', 'page', 'position', 'language_id',
    ];

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     */
    public function scopeActive($query): void
    {
        $query->where('status', 1);
    }

    public function language()
    {
        return $this->belongsTo(\App\Models\Language::class);
    }
}
