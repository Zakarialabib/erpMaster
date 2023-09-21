<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Livewire\Utils\Datatable;
use Livewire\Attributes\Computed;

class Subcategories extends Component
{
    use Datatable;

    public $model = Product::class;

    public $subcategory_id;

    public $sorting;

    public $filterProductSubcategories;

    public function filterProductSubcategories($subcategory_id): void
    {
        $this->subcategory_id = $subcategory_id;
        $this->resetPage();
    }

    #[Computed]
    public function subcategories()
    {
        return Subcategory::active()->get();
    }

    public function render(): View|Factory
    {
        $query = Product::active()->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        if ($this->sorting === 'name') {
            $products = $query->orderBy('name', 'asc')->paginate($this->perPage);
        } elseif ($this->sorting === 'name-desc') {
            $products = $query->orderBy('name', 'desc')->paginate($this->perPage);
        } elseif ($this->sorting === 'price') {
            $products = $query->orderBy('price', 'asc')->paginate($this->perPage);
        } elseif ($this->sorting === 'price-desc') {
            $products = $query->orderBy('price', 'desc')->paginate($this->perPage);
        } elseif ($this->sorting === 'date') {
            $products = $query->orderBy('created_at', 'asc')->paginate($this->perPage);
        } elseif ($this->sorting === 'date-desc') {
            $products = $query->orderBy('created_at', 'desc')->paginate($this->perPage);
        } elseif ($this->subcategory_id) {
            $products = $query->where('subcategory_id', $this->subcategory_id)->paginate($this->perPage);
        } else {
            $products = $query->paginate($this->perPage);
        }

        return view('livewire.front.subcategories', ['products' => $products]);
    }
}
