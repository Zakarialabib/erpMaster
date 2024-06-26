<?php

declare(strict_types=1);

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

trait ProductScope
{
    /** @return mixed */
    public function scopeStockValue(Builder $builder, Carbon $date)
    {
        return $builder->whereDate('created_at', '>=', $date)->sum(DB::raw('quantity * cost'));
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeProductsByCategory($query, $category_id)
    {
        return $query->where('category_id', $category_id)->count();
    }
}
