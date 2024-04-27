<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ProductWarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'warehouse_id' => $this->warehouse_id,
            'product_id'   => $this->product_id,
            'id'           => $request->id,
            'qty'          => $request->qty,
            'price'        => $request->price,
            'cost'         => $request->cost,
        ];
    }
}
