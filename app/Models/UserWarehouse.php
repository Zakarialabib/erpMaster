<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserWarehouse extends Pivot
{
    protected $table = 'user_warehouse';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'warehouse_id',
    ];

    /** @return HasMany<Warehouse> */
    public function assignedWarehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class, 'id', 'warehouse_id');
    }
}
