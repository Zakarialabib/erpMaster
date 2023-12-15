<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'data'  => OrderResource::collection($this->collection),
            'links' => [
                'meta' => ['order_count' => $this->collection->count()],
            ],
        ];
    }
}
