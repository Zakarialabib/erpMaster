<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasAdvancedFilter;

    /** @var array<int, string> */
    public const ATTRIBUTES = [
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

    /** @return hasMany<Blog> */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /** @return BelongsTo<Language> */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id')->withDefault();
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_replace(' ', '-', $value);
    }


    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
