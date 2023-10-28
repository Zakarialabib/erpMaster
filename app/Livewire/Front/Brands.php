<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Livewire\Utils\Front\WithModels;

#[Layout('components.layouts.guest')]
class Brands extends Component
{
    use WithPagination;
    use WithModels;

    public $listeners = [
        'load-more' => 'loadMore',
    ];

    public int $perPage;

    public array $paginationOptions;

    public $category_id;

    public $subcategory_id;

    public $brand_id;

    public $sorting;

    public $sortingOptions;

    public $selectedFilters = [];

    protected $queryString = [
        'category_id'    => ['except' => '', 'as' => 'c'],
        'subcategory_id' => ['except' => '', 'as' => 's'],
        'brand_id'       => ['except' => '', 'as' => 'b'],
        'sorting'        => ['except' => '', 'as' => 'filters'],
    ];

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function filterProducts($type, $value): void
    {
        switch ($type) {
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
        switch ($filter) {
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
        $this->sortingOptions = [
            'name-asc'   => __('Order Alphabetic, A-Z'),
            'name-desc'  => __('Order Alphabetic, Z-A'),
            'date-asc'   => __('Date, new to old'),
            'date-desc'  => __('Date, old to new'),
        ];
        $this->perPage = 25;
        $this->paginationOptions = [25, 50, 100];
    }

    public function loadMore(): void
    {
        $this->perPage += 25;
    }

    public function render(): View|Factory
    {
        $query = \App\Helpers::getEcommerceProducts()
            ->when($this->category_id, fn ($query) => $query->where('category_id', $this->category_id))
            ->when($this->subcategory_id, fn ($query) => $query->whereIn('subcategories', $this->subcategory_id))
            ->when($this->brand_id, fn ($query) => $query->where('brand_id', $this->brand_id));

        if ($this->sorting === 'name') {
            $products = $query->orderBy('name', 'asc')->paginate($this->perPage);
        } elseif ($this->sorting === 'name-desc') {
            $products = $query->orderBy('name', 'desc')->paginate($this->perPage);
        } elseif ($this->sorting === 'date') {
            $products = $query->orderBy('created_at', 'asc')->paginate($this->perPage);
        } elseif ($this->sorting === 'date-desc') {
            $products = $query->orderBy('created_at', 'desc')->paginate($this->perPage);
        } else {
            $products = $query->paginate($this->perPage);
        }

        $this->dispatch('productsLoaded', $products->count());

        return view('livewire.front.brands', ['products' => $products]);
    }
}
