<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DeviceModelType;
use App\Enums\Status;
use App\Support\HasAdvancedFilter;
use App\Trait\GetModelByUuid;
use App\Trait\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DeviceModel
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property string $code
 * @property DeviceModelType $type
 * @property array|null $technical_details
 * @property array|null $features
 * @property array|null $specifications
 * @property string|null $meta_description
 * @property string|null $meta_title
 * @property int $brand_id
 * @property Status $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property-read \App\Models\Brand $brand
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel advancedFilter($data)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereSpecifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereTechnicalDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceModel whereUuid($value)
 *
 * @mixin \Eloquent
 */
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
