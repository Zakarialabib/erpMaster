<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait HasUuid
{
    public static function bootHasUuid()
    {
        static::creating(function (Model $model): void {
            if (Schema::hasColumn($model->getTable(), 'id')) {
                $model->id = Str::uuid()->toString();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}