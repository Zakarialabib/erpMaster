<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Livewire\Utils\Admin\WithMeta;
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
    use WithMeta;

    /** @var bool */
    public $createModal = false;

    public $image;

    public $code;

    public array $gallery = [];

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

    public string $usage;

    public $embeded_video;

    public $category_id;

    public $brand_id;

    public array $subcategories = [];

    public array $options = [];

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

    #[On('editorjs-save')]
    public function saveEditorState($editorJsonData): void
    {
        $this->description = $editorJsonData;
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

        if ($this->gallery) {
            $gallery = [];

            foreach ($this->gallery as $value) {
                $imageName = Str::slug($this->name).'-'.Str::random(5).'.'.$value->extension();
                $gallery[] = $imageName;
            }

            $this->gallery = json_encode($gallery);
        }

        $this->description = json_encode($this->description);

        Product::create($this->all());

        foreach ($this->productWarehouse as $warehouseId => $warehouse) {
            $quantity = $warehouse['quantity'] ?? 0;
            $price = $warehouse['price'] * 100;
            $cost = $warehouse['cost'] * 100;

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
        if (auth()->check()) {
            $user = auth()->user();

            return Warehouse::whereIn('id', $user->warehouses->pluck('id'))->select('name', 'id')->get();
        }

        return Warehouse::select('name', 'id')->get();
    }
}
