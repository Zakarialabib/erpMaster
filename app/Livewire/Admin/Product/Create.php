<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Product;

use App\Helpers;
use App\Livewire\Utils\Front\WithModels;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    use WithModels;

    public $createModal = false;

    public $product;

    public $subcategories;

    public $image;

    public $gallery = [];

    public $options = [];

    public $uploadLink;

    public $description;

    public $width = 1000;

    public $height = 1000;

    public array $listsForFields = [];

    protected $rules = [
        'product.name'             => ['required', 'string', 'max:255'],
        'product.price'            => ['required', 'numeric', 'max:2147483647'],
        'product.old_price'        => ['required', 'numeric', 'max:2147483647'],
        'description'              => ['nullable'],
        'image'                    => ['image', 'required'],
        'product.meta_title'       => ['nullable', 'string', 'max:255'],
        'product.meta_description' => ['nullable', 'string', 'max:255'],
        'product.category_id'      => ['required', 'integer'],
        'product.subcategories'    => ['required', 'array', 'min:1'],
        'product.subcategories.*'  => ['integer', 'distinct:strict'],
        'options.*.type'           => ['required', 'string', 'in:color,size'],
        'options.*.value'          => ['required_if:options.*.type,color', 'string'],
        'product.brand_id'         => ['nullable', 'integer'],
        'product.embeded_video'    => ['nullable'],
        'product.condition'        => ['nullable'],
    ];

    public function fetchSubcategories(): void
    {
        $selectedCategory = $this->product['category_id'];
        $this->subcategories = Subcategory::where('category_id', $selectedCategory)->get();
    }

    public function render(): View|Factory
    {
        return view('livewire.admin.product.create');
    }

    #[On('createModal')]
    public function createModal(): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->product = new Product();

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        $this->product->code = Str::slug($this->product->name, '-');

        $this->product->slug = Str::slug($this->product->name);

        if ($this->image) {
            $imageName = Helpers::handleUpload($this->image, $this->width, $this->height, $this->product->name);

            $this->product->image = $imageName;
        }

        if ($this->gallery) {
            $gallery = [];

            foreach ($this->gallery as $image) {
                $imageName = Str::slug($this->product->name).'.'.$image->extension();
                $image->storeAs('products', $imageName);
                $gallery[] = $imageName;
            }

            $this->product->gallery = json_encode($gallery, JSON_THROW_ON_ERROR);
        }

        $this->product->subcategories = $this->subcategories;
        $this->product->description = $this->description;

        $this->product->save();

        $this->alert('success', 'Product created successfully');

        $this->createModal = false;
    }
}
