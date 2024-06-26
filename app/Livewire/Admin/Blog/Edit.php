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

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $editModal = false;

    public $blog;

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

    #[Computed]
    public function blogCategories()
    {
        return BlogCategory::select('title', 'id')->get();
    }

    #[On('editModal')]
    public function editModal($id): void
    {
        // abort_if(Gate::denies('blog edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->blog = Blog::where('id', $id)->firstOrFail();
        $this->title = $this->blog->title;
        $this->category_id = $this->blog->category_id;
        $this->slug = $this->blog->slug;
        $this->meta_title = $this->blog->meta_title;
        $this->meta_description = $this->blog->meta_description;
        $this->image = $this->blog->image;
        $this->description = $this->blog->description;

        $this->editModal = true;
    }

    public function render()
    {
        // abort_if(Gate::denies('blog create'), 403);

        return view('livewire.admin.blog.edit');
    }

    public function update(): void
    {
        if ( ! $this->image) {
            $this->image = null;
        } elseif (is_object($this->image) && method_exists($this->image, 'extension')) {
            $imageName = Str::slug($this->title).'.'.$this->image->extension();
            $this->image->storeAs('blogs', $imageName);
            $this->blog->image = $imageName;
        }

        $this->blog->description = $this->description;
        $this->blog->language_id = 1;

        $validated = $this->validate();

        $this->blog->update($validated);

        $this->alert('success', __('Blog updated successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->editModal = false;
    }
}
