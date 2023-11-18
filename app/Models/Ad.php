<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use App\Trait\GetModelByUuid;
use App\Trait\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AdType;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ad extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use UuidGenerator;
    use GetModelByUuid;

    public const ATTRIBUTES = [
        'id',
        'status',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $orderable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'package_id',
        'title',
        'social_media',
        'type',
        'image',
        'url',
        'views',
        'amount',
        'notes',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => Status::class,
        'type'   => AdType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id')->whereNotNull('packages.updated_at');
    }

    public function userViews(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ads_user', 'ads_id', 'user_id');
    }

    public function getTotalPayment()
    {
        return $this->getFormatedPrice($this->package()->first()->price * $this->views);
    }
}
