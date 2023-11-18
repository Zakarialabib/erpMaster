<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \App\Models\User  $resource
     * @return array
     */
    public function toArray($resource)
    {
        $relations = [
            'role' => $this->resource->roles()->first(),
            'client' => $this->resource->clients()->where('is_default', true)->first() ?: null,
            'warehouse' => $this->resource->warehouses()->where('is_default', true)->first(),
            'provider' => $resource->providers()->first(),
        ];

        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'email' => $resource->email,
            'avatar' => $resource->avatar,
            'phone' => $resource->phone,
            'city' => $resource->city,
            'address' => $resource->address,
            'country' => $resource->country,
            'status' => $resource->status,
            'is_all_warehouses' => $resource->is_all_warehouses,
            'default_client' => isset($relations['client']) ? $relations['client'] : null,
            'default_warehouse' => isset($relations['warehouse']) ? $relations['warehouse'] : null,
            'deleted_at' => $resource->deleted_at,
            'created_at' => $resource->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $resource->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Return the relation loaded with the resource.
     *
     * @return \App\Models\Role
     */
    public function roles()
    {
        return $this->resource->roles()->first();
    }

    /**
     * Return the client if user is a default for it.
     * @return \App\Models\Customer|null
     */
    public function defaultClient()
    {
        return $this->resource->customers()->where('is_default', true)->first();
    }

    /**
     * Return the warehouse if user has a default for it.
     * @return \App\Models\Warehouse|null
     */
    public function defaultWarehouse()
    {
        return $this->resource->warehouses()->where('is_default', true)->first();
    }


}