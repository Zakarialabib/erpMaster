<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Blog;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $createModal = false;

    public Blog $blog;

    #[Validate('required', message: 'Title is required')]
    public $title;

    #[Validate('required', message: 'Category is required')]
    public $category_id;

    #[Validate('required', message: 'Description is required')]
    #[Validate('min:3', message: 'Description must be at least 3 characters')]
    public $description;

    #[Validate('max:70', message: 'The meta title a max of 170 characters.')]
    public $meta_title;

    #[Validate('max:170', message: 'The meta description a max of 170 characters.')]
    public $meta_description;

    public $slug;

    public $image;

    public function render()
    {
        // abort_if(Gate::denies('blog create'), 403);

        return view('livewire.admin.blog.create');
    }

    #[On('createModal')]
    public function createModal(): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->description = '';

        $this->slug = Str::slug($this->title);

        $this->meta_title = $this->title;

        $this->meta_description = $this->description;

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        if ($this->image) {
            $imageName = Str::slug($this->title).'.'.$this->image->extension();
            $this->image->storeAs('blogs', $imageName);
            $this->blog->image = $imageName;
        }

        $this->blog->language_id = 1;

        $this->blog->description = $this->description;

        $this->blog->save();

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->alert('success', __('Blog created successfully.'));

        $this->createModal = false;
    }

    #[Computed]
    public function blogCategories()
    {
        return BlogCategory::select('title', 'id')->get();
    }
}
