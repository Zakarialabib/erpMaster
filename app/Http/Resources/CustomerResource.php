<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'phone'      => $this->phone,
            'email'      => $this->email,
            'city'       => $this->city,
            'country'    => $this->country,
            'address'    => $this->address,
            'tax_number' => $this->tax_number,
            'status'     => $this->status,
            // 'customerGroup' => $this->customerGroup->name,
            // 'user' => new UserResource(User::find($this->user_id)) ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
