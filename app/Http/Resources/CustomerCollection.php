<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'data'  => CustomerResource::collection($this->collection),
            'links' => [
                'meta' => ['customer_count' => $this->collection->count()],
            ],
        ];
    }
}
