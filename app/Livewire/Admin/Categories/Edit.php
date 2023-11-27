<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    /** @var bool */
    public $editModal = false;

    /** @var mixed */
    public $category;

    #[Rule('required', message: 'Please provide a name')]
    #[Rule('min:3', message: 'This name is too short')]
    public string $name;

    public $description;

    public $slug;

    public $code;

    public $image;

    public function render()
    {
        return view('livewire.admin.categories.edit');
    }

    #[On('editModal')]
    public function editModal($id): void
    {
        abort_if(Gate::denies('category_update'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->category = Category::where('id', $id)->firstOrFail();
        $this->name = $this->category->name;
        $this->description = $this->category->description;
        $this->code = $this->category->code;
        $this->slug = $this->category->slug;
        $this->image = $this->category->image;

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        if ($this->slug !== $this->category->slug) {
            $this->slug = Str::slug($this->name);
        }

        if ($this->image) {
            $imageName = Str::slug($this->name) . '-' . Str::random(3) . '.' . $this->image->extension();
            $this->image->storeAs('categories', $imageName);
            $this->image = $imageName;
        }

        $this->category->update($this->all());

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->alert('success', __('Category updated successfully.'));

        $this->reset(['name', 'description', 'code', 'slug', 'image']);

        $this->editModal = false;
    }
}
