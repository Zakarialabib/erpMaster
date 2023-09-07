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

Should:
#[Layout('components.layouts.dashboard')]
class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $page;

    public $image;

    #[Rule('required|min:3|max:255')]
    public $title;

    #[Rule('required|min:3|max:255')]
    public $slug;

    public $description;

    #[Rule('nullable')]
    public $meta_title;

    #[Rule('nullable')]
    public $meta_description;

    public $is_sliders;

    public $is_contact;

    public $is_offer;

    public $is_title;

    public $is_description;

    public $type;

    public $status;

    #[On('editorjs-save')]
    public function saveEditorState($editorJsonData)
    {
        $this->description = $editorJsonData;
    }

    public function mount($id)
    {
        $this->page = Page::where('id', $id)->firstOrFail();
        $this->title = $this->page->title;
        $this->slug = $this->page->slug;
        $this->type = $this->page->type;
        $this->image = $this->page->image;
        $this->description = $this->page->description;
        $this->meta_title = $this->page->meta_title;
        $this->meta_description = $this->page->meta_description;
        $this->is_sliders = $this->page->is_sliders;
        $this->is_contact = $this->page->is_contact;
        $this->is_offer = $this->page->is_offer;
        $this->is_title = $this->page->is_title;
        $this->is_description = $this->page->is_description;
        $this->status = $this->page->status;
    }

    public function update()
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
