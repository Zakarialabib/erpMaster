<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Page;

use App\Models\Page;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\LazySpinner;
use Livewire\Attributes\Rule;

Should:
#[Layout('components.layouts.dashboard')]
class Create extends Component
{
    use WithFileUploads;
    use LazySpinner;
    use LivewireAlert;

    public Page $page;

    #[Rule('required|min:3|max:255')]
    public $title;
    #[Rule('required|min:3|max:255')]
    public $slug;
    public $description;
    #[Rule('nullable')]
    public $meta_title;
    #[Rule('nullable')]
    public $meta_description;
    public $image = '';
    public bool $is_sliders = false;
    public bool $is_contact = false;
    public bool $is_offer = false;
    public bool $is_title = true;
    public bool $is_description = true;
    public $status;
    public $type;

    #[On('editorjs-save')]
    public function saveEditorState($editorJsonData)
    {
        $this->description = $editorJsonData;
    }

    public function store()
    {
        if ( ! $this->image) {
            $this->image = null;
        } elseif (is_object($this->image) && method_exists($this->image, 'extension')) {
            $imageName = Str::slug($this->title).$this->image->extension();
            $this->image->store('pages', $imageName);
            $this->image = $imageName;
        }

        $this->slug = Str::slug($this->title);
        $this->description = json_encode($this->description);

        $this->meta_title = Str::limit($this->title, 55);

        Page::create($this->all());

        $this->alert('success', 'Page successfully created.');

        return $this->redirect('page/edit', $this->slug);
    }

    public function render()
    {
        return view('livewire.admin.page.create');
    }
}
