<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

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
use App\Livewire\Utils\Admin\WithMeta;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Edit extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithMeta;

    public $product;

    public $productWarehouses;

    #[Rule('required|string|min:3|max:255')]
    public string $name;

    public string $barcode_symbology;

    public string $code;

    public string $slug;

    public string $unit;

    public int $order_tax;

    public $description;

    public $tax_type;

    public bool $featured = false;

    public $usage;

    public $embeded_video;

    public $category_id;

    public $brand_id;

    #[Rule('array')]
    public array $subcategories = [];

    #[Rule('array')]
    public array $options = [];

    public $image;

    public $gallery = [];

    public bool $best = false;

    public bool $hot = false;

    public $productWarehouse = [];

    /** @var array */
    protected $rules = [
        'productWarehouse.*.quantity'    => 'integer|min:1',
        'productWarehouse.*.price'       => 'numeric',
        'productWarehouse.*.old_price'        => 'numeric',
        'productWarehouse.*.cost'        => 'numeric',
        'productWarehouse.*.stock_alert' => 'numeric',
        'productWarehouse.*.is_ecommerce' => '',
        'options.*.type'                 => '',
        'options.*.value'                => '',
    ];

    #[On('editorjs-save')]
    public function saveEditorState($editorJsonData): void
    {
        $this->description = $editorJsonData;
    }

    public function addOption(): void
    {
        $this->options[] = [
            'type'  => '',
            'value' => '',
        ];
    }

    public function removeOption($index): void
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function mount($id): void
    {
        $this->product = Product::findOrFail($id);

        $this->code = $this->product->code;
        $this->name = $this->product->name;
        $this->slug = $this->product->slug;
        $this->embeded_video = $this->product->embeded_video;
        $this->category_id = $this->product->category_id;
        $this->brand_id = $this->product->brand_id;
        $this->order_tax = $this->product->order_tax;
        $this->tax_type = $this->product->tax_type;
        $this->usage = $this->product->usage;
        $this->unit = $this->product->unit;
        $this->barcode_symbology = $this->product->barcode_symbology;
        $this->meta_title = $this->product->meta_title;
        $this->meta_description = $this->product->meta_description;

        $this->subcategories = $this->product->subcategories;

        $this->description = $this->product->description;

        $this->options = $this->product->options ?? [['type' => '', 'value' => '']];

        $this->productWarehouses = $this->product->warehouses;

        $this->productWarehouse = $this->productWarehouses->mapWithKeys(static fn ($warehouse): array => [$warehouse->id => [
            'price' => $warehouse->pivot->price,
            'qty'   => $warehouse->pivot->qty,
            'cost'  => $warehouse->pivot->cost,
            'old_price'  => $warehouse->pivot->old_price,
            'stock_alert'  => $warehouse->pivot->stock_alert,
            'is_ecommerce'  => $warehouse->pivot->is_ecommerce,
        ]])->toArray();
    }

    public function update(): void
    {
        $this->validate();

        if ($this->slug) {
            $this->slug = Str::slug($this->name);
        }

        
        if ($this->image) {
            $imageName = Str::slug($this->name) . '-' . Str::random(5) . '.' . $this->image->extension();
            $this->image->storeAs('products', $imageName , 'local_files');
            $this->image = $imageName;
        }

        if ($this->gallery) {
            $gallery = [];

            foreach ($this->gallery as $value) {
                $imageName = Str::slug($this->name) . '-' . Str::random(5) . '.' . $value->extension();
                $value->storeAs('products', $imageName , 'local_files');
                $gallery[] = $imageName;
            }

            $this->gallery = json_encode($gallery, JSON_THROW_ON_ERROR);
        }

        $this->product->update($this->all());

        foreach ($this->productWarehouse as $warehouseId => $warehouse) {
            $this->product->warehouses()->updateExistingPivot($warehouseId, [
                'price' => $warehouse['price'],
                'qty'   => $warehouse['qty'],
                'cost'  => $warehouse['cost'],
                'old_price'  => $warehouse['old_price'],
                'stock_alert'  => $warehouse['stock_alert'],
                'is_ecommerce'  => $warehouse['is_ecommerce'],
            ]);
        }

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->alert('success', __('Product updated successfully.'));
    }

    #[Computed]
    public function categories()
    {
        return Category::pluck('name', 'id')->toArray();
    }

    #[Computed]
    public function getSubcategories()
    {
        return Subcategory::where('category_id', $this->category_id)->get();
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
