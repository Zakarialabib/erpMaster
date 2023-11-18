<?php

namespace App\Http\Resources;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \App\Models\Order $resource
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'date' => $this->resource->date,
            'reference' => $this->resource->reference,
            'customer' => new CustomerResource(Customer::find($this->resource->customer_id)),
            'shipping' => new ShippingResource(Shipping::find($this->resource->shipping_id)),
            'tax_amount' => $this->resource->tax_amount,
            'discount_amount' => $this->resource->discount_amount,
            'total_amount' => $this->resource->total_amount,
            'status' => $this->resource->status,
            'shipping_status' => $this->resource->shipping_status,
            'payment_status' => $this->resource->payment_status,
            'payment_date' => Carbon::parse($this->resource->payment_date)->format('Y-m-d H:i:s'),
            'document' => $this->resource->document,
            'note' => $this->resource->note,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'user' => new UserResource(User::find($this->resource->user_id)),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array, but not serialized.
     *
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function with($request)
    {
        return [
        ];
    }
}
