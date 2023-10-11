<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Brands;

use App\Models\Brand;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use App\Livewire\Utils\Admin\WithMeta;

class Edit extends Component
{
    use WithMeta;
    use LivewireAlert;
    use WithFileUploads;

    public $editModal = false;

    /** @var mixed */
    public $brand;

    #[Rule('required', message: 'Please provide a name')]
    #[Rule('min:3', message: 'This name is too short')]
    public string $name;

    public $description;

    public $slug;

    public $image;

    public $origin;

    #[On('editModal')]
    public function editModal($id): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->brand = Brand::where('id', $id)->firstOrFail();

        $this->name = $this->brand->name;
        $this->description = $this->brand->description;
        $this->slug = $this->brand->slug;
        $this->image = $this->brand->image;
        $this->meta_title = $this->brand->meta_title ?? '';
        $this->meta_description = $this->brand->meta_description ?? '';
        $this->origin = $this->brand->origin ?? '';

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        if ($this->slug !== $this->brand->slug) {
            $this->slug = Str::slug($this->name);
        }

        if ($this->image) {
            $imageName = Str::slug($this->name).'-'.$this->image->extension();
            $this->image->storeAs('brands', $imageName);
            $this->image = $imageName;
        }

        $this->brand->update($this->all());

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->alert('success', __('Brand updated successfully.'));

        $this->editModal = false;
    }

    public function render()
    {
        abort_if(Gate::denies('brand_update'), 403);

        return view('livewire.admin.brands.edit');
    }
}
