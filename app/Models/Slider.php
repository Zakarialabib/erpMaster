<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasAdvancedFilter;
    use HasFactory;

    public const ATTRIBUTES = [
        'id', 'title', 'status',
    ];

    public $orderable = self::ATTRIBUTES;
    public $filterable = self::ATTRIBUTES;

    protected $fillable = [
        'title', 'subtitle', 'description', 'embeded_video', 'image', 'featured', 'link',  'bg_color', 'status',
    ];

    protected $casts = [
        'satuts' => Status::class,
    ];

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return void
     */
    public function scopeActive($query)
    {
        $query->where('status', true);
    }
}
