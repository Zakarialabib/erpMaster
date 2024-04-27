<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Order $resource
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'date'            => $this->date,
            'reference'       => $this->reference,
            'customer'        => new CustomerResource(Customer::find($this->customer_id)) ?? null,
            'shipping'        => new ShippingResource(Shipping::find($this->shipping_id)),
            'user'            => new UserResource(User::find($this->user_id)) ?? null,
            'tax_amount'      => $this->tax_amount,
            'discount_amount' => $this->discount_amount,
            'total_amount'    => $this->total_amount,
            'status'          => $this->status,
            'shipping_status' => $this->shipping_status,
            'payment_status'  => $this->payment_status,
            'payment_date'    => $this->payment_date,
            'document'        => $this->document,
            'note'            => $this->note,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }
}
