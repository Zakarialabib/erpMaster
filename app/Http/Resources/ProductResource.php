<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function toArray($request): array
    {
        return [
            'id'         => $request->id,
            'name'       => $request->name,
            'code'       => $request->code,
            'category'   => new CategoryResource($request->category_id),
            'price'      => $request->price,
            'quantity'   => $request->quantity,
            'created_at' => (string) $request->created_at,
            'updated_at' => (string) $request->updated_at,
        ];
    }
}
