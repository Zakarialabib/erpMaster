<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Subcategory;

use App\Models\Category;
use App\Models\Language;
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

    #[Rule('required', message: 'Please provide a name')]
    #[Rule('min:3', message: 'This name is too short')]
    public string $name;

    #[Rule('nullable')]
    public string $slug;

    #[Rule('nullable')]
    public int $category_id;

    #[Rule('nullable')]
    public int $language_id;

    public $image;

    public function render(): View|Factory
    {
        abort_if(Gate::denies('subcategory create'), 403);

        return view('livewire.admin.subcategory.create');
    }

    #[On('createModal')]
    public function createModal()
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create()
    {
        $this->validate();

        $this->slug = Str::slug($this->name);

        if ($this->image) {
            $imageName = Str::slug($this->name).'-'.$this->image->extension();
            $this->image->storeAs('subcategories', $imageName);
            $this->image = $imageName;
        }

        Subcategory::create($this->all());

        $this->alert('success', __('Subcategory created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->reset('name', 'slug', 'category_id', 'language_id', 'image');

        $this->createModal = false;
    }

    #[Computed]
    public function categories()
    {
        return Category::select('name', 'id')->get();
    }

    #[Computed]
    public function languages()
    {
        return Language::select('name', 'id')->get();
    }
}
