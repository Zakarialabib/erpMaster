<?php

namespace App\Http\Resources;

use App\Models\Shipping;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \App\Models\Shipping $resource
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->resource->id,
            'is_pickup' => $this->resource->is_pickup,
            'title' => $this->resource->title,
            'subtitle' => $this->resource->subtitle,
            'cost' => (float) $this->resource->cost,
            'status' => $this->resource->status,
            'deleted_at' => $this->resource->deleted_at ? $this->resource->deleted_at->format('Y-m-d H:i:s') : null, // Use Carbon to format datetime for human readable output
            'created_at' => $this->resource->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
