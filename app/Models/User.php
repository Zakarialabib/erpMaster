<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Support\HasAdvancedFilter;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Enums\Status;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use HasApiTokens;
    use HasAdvancedFilter;
    use HasFactory;
    use HasUuid;

    protected array $guard_name = ['admin', 'web'];

    final public const ATTRIBUTES = [
        'id', 'name', 'email', 'password', 'avatar',
        'phone', 'role_id', 'status', 'is_all_warehouses',
        'created_at', 'updated_at', 'provider_id', 'provider_name',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'avatar',
        'phone', 'role_id', 'status', 'is_all_warehouses',
        'default_client_id', 'default_warehouse_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status'            => Status::class,
    ];

    /** @return mixed */
    public function scopeIsActive(Builder $builder)
    {
        return $builder->whereIsActive(true);
    }

    /** @return BelongsToMany<Warehouse> */
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class)->using(UserWarehouse::class)
            ->withPivot('user_id', 'warehouse_id', 'is_default');
    }
}
