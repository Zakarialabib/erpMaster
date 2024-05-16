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

#[Layout('components.layouts.dashboard')]
class Create extends Component
{
    use WithFileUploads;
    use LazySpinner;
    use LivewireAlert;

    public Page $page;

    #[Validate('required', message: 'The title is required')]
    #[Validate('min:3', message: 'The title must be at least 3 characters')]
    #[Validate('max:255', message: 'The title must not exceed 255 characters')]
    public $title;

    #[Validate('required|min:3|max:255')]
    public $slug;

    public $description;

    #[Validate('max:70', message: 'The meta title a max of 170 characters.')]
    public $meta_title;

    #[Validate('max:170', message: 'The meta description a max of 170 characters.')]
    public $meta_description;

    public $image = '';

    #[Validate('array')]
    public $settings = [
        'is_title'        => true,
        'is_description'  => false,
        'is_sliders'      => false,
        'is_gallery'      => false,
        'is_contact'      => false,
        'is_map'          => false,
        'is_video'        => false,
        'is_testimonials' => false,
        'is_team'         => false,
        'is_faq'          => false,
        'is_services'     => false,
        'is_partners'     => false,
        'is_blogs'        => false,
        'is_categories'   => false,
        'is_products'     => false,
        'is_about'        => false,
    ];

    public $status;

    public $type;

    #[On('editorjs-save')]
    public function saveEditorState($editorJsonData): void
    {
        $this->description = $editorJsonData;
    }

    public function store()
    {
        if ( ! $this->image) {
            $this->image = null;
        } elseif (is_object($this->image) && method_exists($this->image, 'extension')) {
            $imageName = Str::slug($this->title).$this->image->extension();
            $this->image->storeAs('pages', $imageName, 'local_files');
            $this->image = $imageName;
        }

        $this->slug = Str::slug($this->title);
        $this->description = json_encode($this->description);

        $this->meta_title = Str::limit($this->title, 55);

        $this->settings = json_encode($this->settings);

        Page::create($this->all());

        $this->alert('success', 'Page successfully created.');

        return $this->redirect('page/edit', $this->slug);
    }

    public function render()
    {
        return view('livewire.admin.page.create');
    }
}
