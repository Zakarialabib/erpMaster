<?php

namespace App\Http\Resources;

use App\Models\CashRegister;
use Illuminate\Http\Resources\Json\JsonResource;

class CashRegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array. */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            // ...
        ];
    }
}
