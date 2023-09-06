<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductWarehouse;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    /** @var bool */
    public $createModal = null;

    public $image;
    public $gallery = [];

    public Product $product;

    #[Rule('required|string|min:3|max:255')]
    public string $name;

    public string $barcode_symbology;

    public string $slug;

    public string $unit;

    public int $order_tax;

    public $description;
    public int $tax_type;
    public bool $featured;
    public string $condition;
    public $embeded_video;
    public $category_id;
    public $brand_id;
    public array $subcategories = [];
    public array $options = [];
    public string $meta_title;
    public string $meta_description;
    public bool $best;
    public bool $hot;

    public $productWarehouse = [];

    /** @var array */
    protected $rules = [
        'productWarehouse.*.quantity'    => 'integer|min:1',
        'productWarehouse.*.price'       => 'numeric',
        'productWarehouse.*.cost'        => 'numeric',
        'productWarehouse.*.stock_alert' => 'required|integer|min:0|max:192',
    ];

    public function render()
    {
        abort_if(Gate::denies('product create'), 403);

        return view('livewire.admin.products.create');
    }

    #[On('createModal')]
    public function createModal(): void
    {
        $this->resetErrorBag();

        $this->resetValidation();
        $this->order_tax = 0;
        $this->unit = 'pcs';
        $this->featured = false;
        $this->barcode_symbology = 'C128';
        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        $this->slug = Str::slug($this->name);

        if ($this->image) {
            $imageName = Str::slug($this->name).'-'.$this->image->extension();
            $this->image->store('products', $imageName);
            $this->image = $imageName;
        }

        Product::create($this->all());

        foreach ($this->productWarehouse as $warehouseId => $warehouse) {
            $quantity = $warehouse['quantity'] ?? 0;
            $price = $warehouse['price'];
            $cost = $warehouse['cost'];

            ProductWarehouse::create([
                'product_id'   => $this->product->id,
                'warehouse_id' => $warehouseId,
                'price'        => $price,
                'cost'         => $cost,
                'qty'          => $quantity,
            ]);
        }

        $this->alert('success', __('Product created successfully'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->createModal = false;
    }

    #[Computed]
    public function categories()
    {
        return Category::pluck('name', 'id')->toArray();
    }

    #[Computed]
    public function brands()
    {
        return Brand::pluck('name', 'id')->toArray();
    }

    #[Computed]
    public function warehouses()
    {
        return Warehouse::select(['name', 'id'])->get();
    }
}
