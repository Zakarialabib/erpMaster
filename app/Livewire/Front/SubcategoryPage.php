<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\Brand;
use App\Models\Subcategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.guest')]
class SubcategoryPage extends Component
{
    use WithPagination;

    public $listeners = [
        'load-more' => 'loadMore',
    ];

    public int $perPage = 25;

    public $sorting;

    public array $paginationOptions = [25, 50, 100];

    public array $sortingOptions;

    public $subcategory;

    public $brand_id;

    public function getBrandsProperty()
    {
        return Brand::active()->get();
    }

    public function filterProducts($type, $value): void
    {
        if ($type === 'brand') {
            $this->brand_id = $value;
        }

        $this->resetPage();
    }

    public function clearFilter($filter): void
    {
        if ($filter === 'brand') {
            $this->brand_id = null;
        }

        $this->resetPage();
    }

    public function mount($slug): void
    {
        $this->subcategory = Subcategory::whereSlug($slug)->firstOrFail();

        $this->sortingOptions = [
            'name-asc'   => __('Order Alphabetic, A-Z'),
            'name-desc'  => __('Order Alphabetic, Z-A'),
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
            ->where('subcategories', 'like', '%"' . $this->subcategory->id . '"%')
            ->when($this->brand_id, fn ($query) => $query->where('brand_id', $this->brand_id));

        if ($this->sorting === 'name') {
            $products = $query->orderBy('name', 'asc')->paginate($this->perPage);
        } elseif ($this->sorting === 'name-desc') {
            $products = $query->orderBy('name', 'desc')->paginate($this->perPage);
        }  elseif ($this->sorting === 'date') {
            $products = $query->orderBy('created_at', 'asc')->paginate($this->perPage);
        } elseif ($this->sorting === 'date-desc') {
            $products = $query->orderBy('created_at', 'desc')->paginate($this->perPage);
        } else {
            $products = $query->paginate($this->perPage);
        }


        return view('livewire.front.subcategory-page', [
            'products' => $products,
        ]);
    }
}
