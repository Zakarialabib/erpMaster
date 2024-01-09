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
            'id' => $this->id,
            'category' => new CategoryResource($this->category_id),
            'user' => new UserResource(User::find($this->user_id)), // Nested resource for user relationship
            'warehouse' => new WarehouseResource(Warehouse::find($this->warehouse)), // Nested resource for warehouse relationship
            // 'cash_register' =>$this->cashRegister ? CashRegisterResource::make($this->cashRegister); // Nullable relation converted into a nested resource if necessary
            'date' => $this->date,
            'reference' => $this->reference,
            'description' => $this->description,
            'amount' => (float) $this->amount,
            'document' => $this->document,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
