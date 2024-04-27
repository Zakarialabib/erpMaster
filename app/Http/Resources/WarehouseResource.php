<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Warehouse;

class WarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Warehouse $resource
     * @return array
     */
    public function toArray($request)
    {
        $warehouse = parent::toArray($request);

        $warehouse['user'] = $this->resource->user ? $this->resource->user : null;

        return [
            'id'         => $warehouse->id,
            'name'       => $warehouse->name,
            'city'       => $warehouse->city,
            'address'    => $warehouse->address,
            'phone'      => $warehouse->phone,
            'email'      => $warehouse->email,
            'country'    => $warehouse->country,
            'user'       => new UserResource(User::find($this->resource->user_id)), // Nested resource for user relationship
            'deleted_at' => $warehouse->deleted_at,
            'created_at' => $warehouse->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $warehouse->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
