<?php

declare(strict_types=1);

namespace App\Http\Services\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface FilterSumInterface
{
    /**
     * Apply the sum filter to the query.
     *
     * @param  Builder  $query
     * @return mixed
     */
    public function filterSum($query, mixed $startDate, mixed $endDate);
}
