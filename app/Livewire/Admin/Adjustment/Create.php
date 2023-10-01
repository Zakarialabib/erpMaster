<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Adjustment;

use App\Livewire\Utils\Admin\WithModels;
use App\Models\AdjustedProduct;
use App\Models\Adjustment;
use App\Models\Product;
use App\Models\ProductWarehouse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Throwable;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.dashboard')]
class Create extends Component
{
    use LivewireAlert;
    use WithModels;

    #[Rule('required|date')]
    public $date;

    #[Rule('nullable|string|max:1000')]
    public $note;

    #[Rule('required|string|max:255')]
    public $reference;
    public $quantities;

    public $types;

    public $warehouse_id;

    public $products;

    public $hasAdjustments;

    protected $rules = [
        'products.*.quantities' => 'required|integer|min:1',
        'products.*.types'      => 'required|in:add,sub',
    ];

    public function mount(): void
    {
        $this->products = [];

        $this->reference = 'Adj-'.Str::random(5);
        $this->date = date('Y-m-d');

        if(settings('default_warehouse_id') !== null){
            $this->warehouse_id = settings('default_warehouse_id');
        }
    }

    public function render()
    {
        return view('livewire.admin.adjustment.create');
    }

    public function updatedWarehouseId($value): void
    {
        $this->warehouse_id = $value;
        $this->dispatch('warehouseSelected', $this->warehouse_id);
    }

    public function store()
    {
        abort_if(Gate::denies('adjustment create'), 403);

        if ( ! $this->warehouse_id) {
            $this->alert('error', __('Please select a warehouse'));

            return;
        }

        try {
            $this->validate();

            $adjustment = Adjustment::create([
                'date'         => $this->date,
                'note'         => $this->note,
                'user_id'      => auth()->id(),
                'warehouse_id' => $this->warehouse_id,
            ]);

            foreach ($this->products as $product) {
                AdjustedProduct::create([
                    'adjustment_id' => $adjustment->id,
                    'product_id'    => $product['id'],
                    'warehouse_id'  => $this->warehouse_id,
                    'quantity'      => $product['quantities'],
                    'type'          => $product['types'],
                ]);

                $productWarehouse = ProductWarehouse::where('product_id', $product['id'])
                    ->where('warehouse_id', $this->warehouse_id)
                    ->first();

                if ($product['types'] === 'add') {
                    $productWarehouse->update([
                        'qty' => $productWarehouse->qty + $product['quantities'],
                    ]);
                } elseif ($product['types'] === 'sub') {
                    $productWarehouse->update([
                        'qty' => $productWarehouse->qty - $product['quantities'],
                    ]);
                }
            }

            $this->alert('success', __('Adjustment created successfully'));

            return redirect()->route('admin.adjustments.index');
        } catch (Throwable $throwable) {
            $this->alert('error', 'Error Occurred in '.$throwable->getMessage());
        }
    }

    #[On('productSelected')]
    public function productSelected(array $product): void
    {
        switch ($this->hasAdjustments) {
            case true:
                if (in_array($product, array_map(static fn ($adjustment) => $adjustment['product'], $this->products))) {
                    $this->alert('error', __('Product added succesfully'));

                    return;
                }

                break;
            case false:
                if (in_array($product, $this->products)) {
                    $this->alert('error', __('Already exists in the product list!'));

                    return;
                }

                break;
            default:
                $this->alert('error', __('Something went wrong!'));

                return;
        }

        // add default quantities and types to the product array
        $product['quantities'] = 10;
        $product['types'] = 'add';

        $this->products[] = $product;
    }

    public function removeProduct($key): void
    {
        unset($this->products[$key]);
    }
}
