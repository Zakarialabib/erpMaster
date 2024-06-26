<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SearchProduct extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $product;

    #[Url(as: 'q')]
    public $search = '';

    public $category_id;

    public $warehouse_id;

    public $search_results;

    public int $showCount = 9;

    public bool $featured = false;

    public function loadMore(): void
    {
        $this->showCount += 5;
    }

    public function selectProduct($id): void
    {
        if ($this->warehouse_id !== null) {
            $this->dispatch('productSelected', $id);
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

    #[Computed]
    public function categories()
    {
        return Category::pluck('name', 'id');
    }

    public function mount($warehouse_id = null): void
    {
        if ($warehouse_id) {
            $this->warehouse_id = $warehouse_id;
        } else {
            $this->warehouse_id = settings('default_warehouse_id');
        }
    }

    public function render()
    {
        $query = Product::with(['warehouses' => static function ($query): void {
            $query->withPivot('qty', 'price', 'cost');
        }, 'category'])
            ->when($this->search, function ($query): void {
                $query->where(function ($query): void {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('code', 'like', '%'.$this->search.'%');
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
        $this->reset(['search', 'category_id', 'featured', 'warehouse_id']);
    }

    public function updatedQuery(): void
    {
        if ( ! empty($this->search_results)) {
            $this->product = $this->search_results[0];
            $this->dispatch('productSelected', $this->product);
        }
    }
}
