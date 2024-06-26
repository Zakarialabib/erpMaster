<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Brands;

use App\Models\Brand;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $createModal = false;

    public Brand $brand;

    #[Validate('required', message: 'Please provide a name')]
    #[Validate('min:3', message: 'This name is too short')]
    public string $name;

    public $description;

    public $slug;

    public $image;

    public $featured_image;

    public $origin;

    #[Validate('max:70', message: 'The meta title a max of 170 characters.')]
    public $meta_title;

    #[Validate('max:170', message: 'The meta description a max of 170 characters.')]
    public $meta_description;

    #[On('createModal')]
    public function createModal(): void
    {
        abort_if(Gate::denies('brand create'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        $this->slug = Str::slug($this->name);

        if ($this->image) {
            $imageName = Str::slug($this->name).'-'.Str::random(5).'.'.$this->image->extension();
            $this->image->storeAs('brands', $imageName);
            $this->image = $imageName;
        }

        $this->meta_title = $this->name;
        $this->meta_description = Str::limit($this->description, 160);

        Brand::create($this->all());

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->alert('success', __('Brand created successfully.'));

        $this->reset(['name', 'description', 'slug', 'image']);

        $this->createModal = false;
    }

    public function render()
    {
        abort_if(Gate::denies('brand create'), 403);

        return view('livewire.admin.brands.create');
    }
}
