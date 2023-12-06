<?php

namespace App\Http\Resources;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \App\Models\Customer $resource
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $request->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'city' => $request->city,
            'country' => $request->country,
            'address' => $request->address,
            'tax_number' => $request->tax_number,
            'status' => $request->status,
            'customerGroup' => $request->customerGroup->name,
            'user' => new UserResource(User::find($request->user_id)), 
            'created_at' => (string) $request->created_at, 
            'updated_at' => (string) $request->updated_at,
        ];
    }
}
