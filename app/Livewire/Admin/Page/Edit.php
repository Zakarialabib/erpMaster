<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Page;

use App\Models\Page;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.dashboard')]
class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $page;

    public $image;

    #[Validate('required', message: 'The title is required')]
    #[Validate('min:3', message: 'The title must be at least 3 characters')]
    #[Validate('max:255', message: 'The title must not exceed 255 characters')]
    public $title;

    public $slug;

    public $description;

    #[Validate('array')]
    public $settings;

    public $type;

    public $status;

    #[Validate('max:70', message: 'The meta title a max of 170 characters.')]
    public $meta_title;

    #[Validate('max:170', message: 'The meta description a max of 170 characters.')]
    public $meta_description;

    #[On('editorjs-save')]
    public function saveEditorState($editorJsonData): void
    {
        $this->description = $editorJsonData;
    }

    public function mount($id): void
    {
        $this->page = Page::where('id', $id)->firstOrFail();
        $this->title = $this->page->title;
        $this->slug = $this->page->slug;
        $this->type = $this->page->type;
        $this->image = $this->page->image;
        $this->description = $this->page->description;
        $this->meta_title = $this->page->meta_title;
        $this->meta_description = $this->page->meta_description;

        // is string or is array
        if (is_string($this->page->settings)) {
            $this->settings = json_decode($this->page->settings, true, 512, JSON_THROW_ON_ERROR);
        } else {
            $this->settings = $this->page->settings;
        }

        $this->status = $this->page->status;
    }

    public function update(): void
    {
        $this->validate();

        $this->page->slug = Str::slug($this->page->name);

        if ( ! $this->image) {
            $this->image = null;
        } elseif (is_object($this->image) && method_exists($this->image, 'extension')) {
            $imageName = Str::slug($this->page->name).'.'.$this->image->extension();
            $this->image->storeAs('pages', $imageName, 'local_files');
            $this->page->image = $imageName;
        }

        $this->page->settings = json_encode($this->settings, JSON_THROW_ON_ERROR);

        $this->page->update(
            $this->all()
        );

        $this->alert('success', __('Page updated successfully.'));
    }

    public function render()
    {
        return view('livewire.admin.page.edit');
    }
}
