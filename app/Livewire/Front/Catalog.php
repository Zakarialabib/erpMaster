<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Livewire\Utils\Front\WithModels;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.guest')]
class Catalog extends Component
{
    use WithPagination;
    use WithModels;

    public $maxPrice;

    public $minPrice;

    public $category_id;

    public $subcategory_id;

    public $brand_id;

    public int $perPage = 25;

    public $sorting;

    public $sortingOptions;

    public $paginationOptions;

    public $selectedFilters = [];

    protected $queryString = [
        'category_id'    => ['except' => '', 'as' => 'c'],
        'subcategory_id' => ['except' => '', 'as' => 's'],
        'brand_id'       => ['except' => '', 'as' => 'b'],
        'sorting'        => ['except' => '', 'as' => 'f'],
        'maxPrice'       => ['except' => '', 'as' => 'max'],
        'minPrice'       => ['except' => '', 'as' => 'min'],
    ];

    public function filterProducts($type, $value): void
    {
        switch($type) {
            case 'category':
                $this->category_id = $value;

                break;
            case 'subcategory':
                $this->subcategory_id = $value;

                break;
            case 'brand':
                $this->brand_id = $value;

                break;
        }

        $this->resetPage();
    }

    public function clearFilter($filter): void
    {
        switch($filter) {
            case 'category':
                $this->category_id = null;
                unset($this->selectedFilters['category']);

                break;
            case 'subcategory':
                $this->subcategory_id = null;
                unset($this->selectedFilters['subcategory']);

                break;
            case 'brand':
                $this->brand_id = null;
                unset($this->selectedFilters['brand']);

                break;
        }

        $this->resetPage();
    }

    public function mount(): void
    {
        $this->paginationOptions = [25, 50, 100];

        $this->sortingOptions = [
            'name-asc'   => __('Order Alphabetic, A-Z'),
            'name-desc'  => __('Order Alphabetic, Z-A'),
            'price-asc'  => __('Price, low to high'),
            'price-desc' => __('Price, high to low'),
            'date-asc'   => __('Date, new to old'),
            'date-desc'  => __('Date, old to new'),
        ];
    }

    public function render(): View|Factory
    {
        $query = \App\Helpers::getEcommerceProducts()
            ->when($this->minPrice, fn($query) => $query->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($query) => $query->where('price', '<=', $this->maxPrice))
            ->when($this->category_id, fn($query) => $query->where('category_id', $this->category_id))
            ->when($this->subcategory_id, fn($query) => $query->whereIn('subcategories', $this->subcategory_id))
            ->when($this->brand_id, fn($query) => $query->where('brand_id', $this->brand_id));

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
        } else {
            $products = $query->paginate($this->perPage);
        }

        return view('livewire.front.catalog', ['products' => $products]);
    }
}
