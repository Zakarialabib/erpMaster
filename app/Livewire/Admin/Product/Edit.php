<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Product;

use App\Helpers;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $product;

    public $subcategories;

    public $editModal = false;

    public $image;

    public $category_id;

    public $gallery = [];

    public $width = 1000;

    public $height = 1000;

    public $description;

    public $options = [];

    public $listeners = [
        'optionUpdated' => 'updatedOptions',
        'editModal',
    ];

    protected $rules = [
    ];

    #[On('editModal')]
    public function editModal($id)
    {
        abort_if(Gate::denies('product_update'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->product = Product::findOrFail($id);

        $this->description = $this->product->description;

        $this->category_id = $this->product->category_id;

        $this->subcategories = $this->product->subcategories;

        $this->options = $this->product->options ?? [['type' => '', 'value' => '']];

        $this->editModal = true;
    }

    public function update()
    {
        abort_if(Gate::denies('product_update'), 403);

        $this->validate();

        if ($this->image) {
            $imageName = Helpers::handleUpload($this->image, $this->width, $this->height, $this->product->name);

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

        $this->product->options = $this->options;

        $this->product->save();

        $this->alert('success', __('Product updated successfully.'));

        $this->editModal = false;
    }

    public function render(): View|Factory
    {
        return view('livewire.admin.product.edit');
    }
}
