<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DeviceModelType;
use App\Enums\Status;
use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    use HasFactory;
    use HasAdvancedFilter;

    public const ATTRIBUTES = [
        'id',
        'name',
        'code',
        'status',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public array $orderable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public array $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'code',
        'technical_details',
        'features',
        'specifications',
        'type',
        'brand_id',
        'url_hash',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'technical_details' => 'array',
        'features'          => 'array',
        'specifications'    => 'array',
        'type'              => DeviceModelType::class,
        'status'            => Status::class,
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeActive($query): void
    {
        $query->where('status', true);
    }
}
