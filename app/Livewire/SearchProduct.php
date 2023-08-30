<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class SearchProduct extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $product;

    public string $query = '';

    public $category_id;

    public $warehouse_id;

    public $search_results;

    public int $showCount = 9;

    public bool $featured = false;

    public $listeners = [
        'warehouseSelected' => 'updatedWarehouseId',
    ];
    protected $queryString = [
        'query'       => ['except' => ''],
        'category_id' => ['except' => null],
        'showCount'   => ['except' => 9],
    ];

    public function loadMore()
    {
        $this->showCount += 5;
    }

    public function selectProduct($product)
    {
        if ($this->warehouse_id !== null) {
            $this->dispatch('productSelected', $product);
        } else {
            $this->alert('error', __('Please select a warehouse!'));
        }
    }

    public function updatedWarehouseId($value)
    {
        $this->warehouse_id = $value;
        $this->resetPage();
    }

    public function getCategoriesProperty()
    {
        return Category::pluck('name', 'id');
    }

    public function mount($warehouse_id = null): void
    {
        $this->warehouse_id = $warehouse_id;
        // Initialize search_results as an array
        $this->search_results = [];
    }

    public function render()
    {
        $query = Product::with(['warehouses' => function ($query) {
            $query->withPivot('qty', 'price', 'cost');
        }, 'category'])
            ->when($this->query, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%'.$this->query.'%')
                        ->orWhere('code', 'like', '%'.$this->query.'%');
                });
            })
            ->when($this->category_id, function ($query) {
                $query->where('category_id', $this->category_id);
            })
            ->when($this->warehouse_id, function ($query) {
                $query->whereHas('warehouses', function ($q) {
                    $q->where('warehouse_id', $this->warehouse_id);
                });
            })
            ->when($this->featured, function ($query) {
                $query->where('featured', true);
            });

        $products = $query->paginate($this->showCount);

        return view('livewire.search-product', [
            'products' => $products,
        ]);
    }

    // Reset query, category, and featured
    public function resetQuery()
    {
        // Reset query, category, and featured
        $this->reset(['query', 'category_id', 'featured', 'warehouse_id']);
    }

    public function updatedQuery()
    {
        if ( ! empty($this->search_results)) {
            $this->product = $this->search_results[0];
            $this->dispatch('productSelected', $this->product);
        }
    }
}
