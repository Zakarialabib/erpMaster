<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Adjustment;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProductTable extends Component
{
    use LivewireAlert;

    public $products;

    public $hasAdjustments;

    protected $listeners = ['productSelected'];

    public function mount($adjustedProducts = null)
    {
        $this->products = [];

        if ($adjustedProducts) {
            $this->hasAdjustments = true;
            $this->products = $adjustedProducts;
        } else {
            $this->hasAdjustments = false;
        }
    }

    public function render()
    {
        return view('livewire.admin.adjustment.product-table');
    }

    public function productSelected($product): void
    {
        switch ($this->hasAdjustments) {
            case true:
                if (in_array($product, array_map(function ($adjustment) {
                    return $adjustment['product'];
                }, $this->products))) {
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

        array_push($this->products, $product);
    }

    public function removeProduct($key): void
    {
        unset($this->products[$key]);
    }
}
