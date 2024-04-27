<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashRegisterResource extends JsonResource
{
    /** Transform the resource into an array. */
    public function toArray($request)
    {
        return [
            'id'   => $this->resource->id,
            'name' => $this->resource->name,
            // ...
        ];
    }
}
