<?php

namespace App\Http\Resources;

use App\Models\Expense;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \App\Models\Expense $resource
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'category' => new CategoryResource($this->resource->category_id),
            'user' => new UserResource(User::find($this->resource->user_id)), // Nested resource for user relationship
            'warehouse' => new WarehouseResource(Warehouse::find($this->resource->warehouse)), // Nested resource for warehouse relationship
            // 'cash_register' =>$this->resource->cashRegister ? CashRegisterResource::make($this->resource->cashRegister); // Nullable relation converted into a nested resource if necessary
            'date' => $this->resource->date,
            'reference' => $this->resource->reference,
            'description' => $this->resource->description,
            'amount' => (float) $this->resource->amount,
            'document' => $this->resource->document,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at
        ];
    }
}
