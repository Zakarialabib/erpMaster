<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Shipping;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Shipping $resource
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $request->id,
            'is_pickup' => $request->is_pickup,
            'title'     => $request->title,
            'subtitle'  => $request->subtitle,
            'cost'      => (float) $request->cost,
            'status'    => $request->status,
        ];
    }
}
