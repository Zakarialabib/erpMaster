<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $product;

    public $productWarehouses;

    public $editModal = false;

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

    #[Rule('required', 'array', 'min:1')]
    public array $subcategories = [];

    #[Rule('array')]
    public array $options = [];

    public string $meta_title;

    public string $meta_description;

    public $image;

    public bool $best;

    public bool $hot;

    public $productWarehouse = [];

    /** @var array */
    protected $rules = [
        'productWarehouse.*.quantity'    => 'integer|min:1',
        'productWarehouse.*.price'       => 'numeric',
        'productWarehouse.*.cost'        => 'numeric',
        'productWarehouse.*.stock_alert' => 'required|integer|min:0|max:192',
        'options.*.type'                 => ['string', 'max:255'],
        'options.*.value'                => ['string', 'max:255'],
    ];

    public function addOption()
    {
        $this->options[] = [
            'type'  => '',
            'value' => '',
        ];
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function fetchSubcategories()
    {
        $selectedCategory = $this->product['category_id'];
        $this->subcategories = Subcategory::where('category_id', $selectedCategory)->get();
    }

    #[On('editModal')]
    public function editModal($id)
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->product = Product::findOrFail($id);

        $this->fetchSubcategories();

        $this->options = $this->product->options ?? [['type' => '', 'value' => '']];

        $this->productWarehouses = $this->product->warehouses()->pivot('price', 'qty', 'cost')->get();

        $this->productWarehouse = $this->productWarehouses->mapWithKeys(static fn($warehouse) => [$warehouse->id => [
            'price' => $warehouse->pivot->price,
            'qty'   => $warehouse->pivot->qty,
            'cost'  => $warehouse->pivot->cost,
        ]])->toArray();

        $this->editModal = true;
    }

    public function update()
    {
        $this->validate();

        if ($this->slug !== $this->product->slug) {
            $this->slug = Str::slug($this->name);
        }

        if ($this->image) {
            $imageName = Str::slug($this->product->name).'-'.Str::random(5).'.'.$this->image->extension();
            $this->image->store('products', $imageName);
            $this->product->image = $imageName;
        }

        if ($this->gallery) {
            $gallery = [];

            foreach ($this->gallery as $value) {
                $imageName = Helpers::handleUpload($value, $this->width, $this->height, $this->product->name);
                $gallery[] = $imageName;
            }

            $this->product->gallery = json_encode($gallery, JSON_THROW_ON_ERROR);
        }

        $this->product->update($this->all());

        foreach ($this->productWarehouse as $warehouseId => $warehouse) {
            $this->product->warehouses()->updateExistingPivot($warehouseId, [
                'price' => $warehouse['price'],
                'qty'   => $warehouse['qty'],
                'cost'  => $warehouse['cost'],
            ]);
        }

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->alert('success', __('Product updated successfully.'));

        $this->editModal = false;
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

    public function render()
    {
        abort_if(Gate::denies('product update'), 403);

        return view('livewire.admin.products.edit');
    }
}
