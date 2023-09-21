<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\HasAdvancedFilter;
use  Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasAdvancedFilter;

    final public const ATTRIBUTES = [
        'id',
        'name',
        'guard_name',
    ];

    public $orderable = self::ATTRIBUTES;

    public $filterable = self::ATTRIBUTES;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['guard_name', 'name', 'description'];

    /**
     * Determine if the permission belongs to the role.
     *
     *
     * @return bool
     */
    public function inRole(mixed $role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return (bool) $role->intersect($this->roles)->count();
    }
}
