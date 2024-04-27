<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Supplier;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Supplier $resource
     * @return array
     */
    public function toArray($request)
    {
        $relationships = [];

        return [
            'id'         => $this->resource->id,
            'name'       => $this->resource->name,
            'email'      => $this->resource->email,
            'phone'      => $this->resource->phone,
            'address'    => $this->resource->address,
            'city'       => $this->resource->city,
            'country'    => $this->resource->country,
            'tax_number' => $this->resource->tax_number,
            'created_at' => $this->resource->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->resource->updated_at->format('Y-m-d H:i:s'),
            // 'user' => new UserResource(User::find($this->resource->user_id)), // Nested resource for user relationship
        ];
    }
}
