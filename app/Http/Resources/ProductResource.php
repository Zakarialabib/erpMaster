<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'code'     => $this->code,
            'category' => new CategoryResource(Category::find($this->category_id)) ?? null,

            'price' => $this->whenPivotLoaded('warehouse', function () {
                return $this->warehouses->first()->pivot->price;
            }),
            'old_price' => $this->whenPivotLoaded('warehouse', function () {
                return $this->warehouses->first()->pivot->old_price;
            }),
            'quantity' => $this->whenPivotLoaded('warehouse', function () {
                return $this->warehouses->first()->pivot->qty;
            }),
            // @foreach ($product->warehouses as $warehouse)
            //     <div class="mr-4 mb-4">
            //         <p class="font-medium">{{ $warehouse->name }}</p>
            //         <p class="text-sm">{{ __('Quantity') }}:
            //             {{ $warehouse->pivot->qty }} {{ $product->unit }}</p>
            //         <p class="text-sm">{{ __('Cost') }}:
            //             {{ format_currency($warehouse->pivot->cost) }}</p>
            //         <p class="text-sm">{{ __('Price') }}:
            //             {{ format_currency($warehouse->pivot->price) }}</p>
            //         <p class="text-sm">{{ __('Stock Worth') }}:
            //             {{ format_currency($warehouse->pivot->cost * $warehouse->pivot->qty) }}
            //         </p>
            //         <p class="text-sm">{{ __('Alert Quantity') }}:
            //             {{ format_currency($warehouse->pivot->stock_alert) }}
            //         </p>
            //     </div>
            // @endforeach

            'image'      => $this->image ? asset("images/products/{$this->image}") : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
