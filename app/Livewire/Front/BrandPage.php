<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\Brand;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Livewire\Utils\Front\WithModels;

#[Layout('components.layouts.guest')]
class BrandPage extends Component
{
    use WithPagination;
    use WithModels;

    public $listeners = [
        'load-more' => 'loadMore',
    ];

    public int $perPage;

    public array $paginationOptions;

    public array $sortingOptions;

    public $brand;

    public $sorting;

    public $category_id;

    public $subcategory_id;

    public $filterProductCategories;

    public $filterProductSubcategories;

    public function filterProductCategories($category_id): void
    {
        $this->category_id = $category_id;
        $this->resetPage();
    }

    public function filterProductSubcategories($subcategory_id): void
    {
        $this->subcategory_id = $subcategory_id;
        $this->resetPage();
    }

    public function mount($brand): void
    {
        $this->brand = Brand::findOrFail($brand->id);
        $this->perPage = 25;
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

    public function loadMore(): void
    {
        $this->perPage += 25;
    }

    public function render(): View|Factory
    {
        $query = \App\Helpers::getEcommerceProducts()
            ->where('brand_id', $this->brand->id)
            ->when($this->category_id, fn ($query) => $query->where('category_id', $this->category_id))
            ->when($this->subcategory_id, fn ($query) => $query->whereIn('subcategories', $this->subcategory_id));

        if ($this->sorting === 'name') {
            $query->orderBy('name', 'asc');
        } elseif ($this->sorting === 'name-desc') {
            $query->orderBy('name', 'desc');
        } elseif ($this->sorting === 'price') {
            $query->orderBy('price', 'asc');
        } elseif ($this->sorting === 'price-desc') {
            $query->orderBy('price', 'desc');
        } elseif ($this->sorting === 'date') {
            $query->orderBy('created_at', 'asc');
        } elseif ($this->sorting === 'date-desc') {
            $query->orderBy('created_at', 'desc');
        }

        $brandproducts = $query->paginate($this->perPage);

        $this->dispatch('productsLoaded', $brandproducts->count());

        return view('livewire.front.brand-page', ['brandproducts' => $brandproducts]);
    }
}
