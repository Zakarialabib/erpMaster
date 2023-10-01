<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Warehouse;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
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

    protected $queryString = [
        'query',
        'category_id' => ['except' => null],
        'showCount'   => ['except' => 9],
    ];

    public function loadMore(): void
    {
        $this->showCount += 5;
    }

    public function selectProduct($product): void
    {
        if ($this->warehouse_id !== null) {
            $this->dispatch('productSelected', $product);
        } else {
            $this->alert('error', __('Please select a warehouse!'));
        }
    }

    #[On('warehouseSelected')]
    public function updatedWarehouseId($value): void
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
        if ($warehouse_id) {
            $this->warehouse_id = $warehouse_id;
        } else {
            $this->warehouse_id = settings('default_warehouse_id');
            // dd($this->w            $this->invoice_header->storeAs('uploads', $imageName, 'public');arehouse_id);
            $this->search_results = [];
        }
    }

    public function render()
    {
        $query = Product::with(['warehouses' => static function ($query): void {
            $query->withPivot('qty', 'price', 'cost');
        }, 'category'])
            ->when($this->query, function ($query): void {
                $query->where(function ($query): void {
                    $query->where('name', 'like', '%'.$this->query.'%')
                        ->orWhere('code', 'like', '%'.$this->query.'%');
                });
            })
            ->when($this->category_id, function ($query): void {
                $query->where('category_id', $this->category_id);
            })
            ->when($this->warehouse_id, function ($query): void {
                $query->whereHas('warehouses', function ($q): void {
                    $q->where('warehouse_id', $this->warehouse_id);
                });
            })
            ->when($this->featured, static function ($query): void {
                $query->where('featured', true);
            });

        $products = $query->paginate($this->showCount);

        return view('livewire.search-product', [
            'products' => $products,
        ]);
    }

    // Reset query, category, and featured
    public function resetQuery(): void
    {
        // Reset query, category, and featured
        $this->reset(['query', 'category_id', 'featured', 'warehouse_id']);
    }

    public function updatedQuery(): void
    {
        if ( ! empty($this->search_results)) {
            $this->product = $this->search_results[0];
            $this->dispatch('productSelected', $this->product);
        }
    }
}
