<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Warehouse;

class WarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \App\Models\Warehouse $resource
     * @return array
     */
    public function toArray($request)
    {
        $warehouse = parent::toArray($request);

        $warehouse['user'] = $this->resource->user ? $this->resource->user : null;

        return [
            'id' => $warehouse->id,
            'name' => $warehouse->name,
            'city' => $warehouse->city,
            'address' => $warehouse->address,
            'phone' => $warehouse->phone,
            'email' => $warehouse->email,
            'country' => $warehouse->country,
            'user' => new UserResource(optional($this->resource->user)), // Retrieve the related user resource if present
            'deleted_at' => $warehouse->deleted_at,
            'created_at' => $warehouse->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $warehouse->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
