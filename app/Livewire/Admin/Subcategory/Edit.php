<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Subcategory;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;
use App\Models\Subcategory;
use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    use LivewireAlert;

    public $editModal = false;

    public $subcategory;

    #[Validate('required', message: 'Please provide a name')]
    #[Validate('min:3', message: 'This name is too short')]
    public string $name;

    public $slug;

    public $category_id;

    public $language_id;

    #[On('editModal')]
    public function editModal($id): void
    {
        abort_if(Gate::denies('subcategory update'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->subcategory = Subcategory::findOrFail($id);

        $this->name = $this->subcategory->name;
        $this->slug = $this->subcategory->slug;
        $this->category_id = $this->subcategory->category_id;
        $this->language_id = $this->subcategory->language_id;

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        if ($this->slug !== $this->subcategory->slug) {
            $this->slug = Str::slug($this->name);
        }

        $this->subcategory->update($this->all());

        $this->alert('success', __('Subcategory updated successfully'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->reset(['name', 'slug', 'category_id', 'language_id']);

        $this->editModal = false;
    }

    #[Computed]
    public function categories()
    {
        return Category::select('name', 'id')->get();
    }

    public function render(): View
    {
        return view('livewire.admin.subcategory.edit');
    }
}
