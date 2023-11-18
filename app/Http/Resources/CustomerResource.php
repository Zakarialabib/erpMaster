<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \App\Models\Customer $resource
     * @return array
     */
    public function toArray($request)
    {
        $relations = [
            'user' => $this->resource->user, // relationship: customer belongsTo(User::class),
            'customerGroup' => $this->resource->group, // relationship: customer hasOne(CustomerGroup::class)
        ];

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'phone' => $this->resource->phone,
            'email' => $this->resource->email,
            'city' => $this->resource->city,
            'country' => $this->resource->country,
            'address' => $this->resource->address,
            'tax_number' => $this->resource->tax_number,
            'status' => $this->resource->status,
            'created_at' => (string) $this->resource->created_at, // convert Carbon to string using format() method
            'updated_at' => (string) $this->resource->updated_at,
            'deleted_at' => $this->resource->deleted_at ? $this->resource->deleted_at->format('Y-m-d H:i:s') : null, // null if deleted_at is null,
            'relations' => $relations,
        ];
    }
}

   