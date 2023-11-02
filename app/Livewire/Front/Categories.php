<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Livewire\Utils\Front\WithModels;

#[Layout('components.layouts.guest')]
class Categories extends Component
{
    use WithPagination;
    use WithModels;

    public $sortingOptions;

    public $sorting = 'name-asc';

    public int $perPage = 25;

    public $category_id;

    public $subcategory_id;

    public $brand_id;

    public array $paginationOptions;

    public $selectedFilters = [];

    protected $queryString = [
        'category_id'    => ['except' => '', 'as' => 'c'],
        'subcategory_id' => ['except' => '', 'as' => 's'],
        'sorting'        => ['except' => '', 'as' => 'f'],
    ];

    public function filterProducts($type, $value): void
    {
        switch ($type) {
            case 'category':
                $this->category_id = $value;

                break;
            case 'subcategory':
                $this->subcategory_id = [$value];

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
            'name-asc'  => __('Order Alphabetic, A-Z'),
            'name-desc' => __('Order Alphabetic, Z-A'),
            'date-asc'  => __('Date, new to old'),
            'date-desc' => __('Date, old to new'),
        ];
    }

    #[On('load-more')]
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
            $products = $query->orderBy('name', 'asc');
        } elseif ($this->sorting === 'name-desc') {
            $products = $query->orderBy('name', 'desc');
        } elseif ($this->sorting === 'date') {
            $products = $query->orderBy('created_at', 'asc');
        } elseif ($this->sorting === 'date-desc') {
            $products = $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate($this->perPage);

        return view('livewire.front.categories', [
            'products' => $products,
        ]);
    }
}
