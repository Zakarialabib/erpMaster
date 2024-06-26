<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Subcategory;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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

    public $createModal = false;

    public Subcategory $subcategory;

    #[Validate('required', message: 'Please provide a name')]
    #[Validate('min:3', message: 'This name is too short')]
    public string $name;

    public $slug;

    public $category_id;

    public $language_id;

    public function render(): View|Factory
    {
        abort_if(Gate::denies('subcategory create'), 403);

        return view('livewire.admin.subcategory.create');
    }

    #[On('createModal')]
    public function createModal(): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        $this->slug = Str::slug($this->name);

        Subcategory::create($this->all());

        $this->alert('success', __('Subcategory created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->reset(['name', 'slug', 'category_id', 'language_id']);

        $this->createModal = false;
    }

    #[Computed]
    public function categories()
    {
        return Category::select('name', 'id')->get();
    }
}
