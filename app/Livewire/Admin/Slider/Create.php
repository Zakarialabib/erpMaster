<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Slider;

use App\Models\Slider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $createModal = false;

    public Slider $slider;

    #[Validate('required|max:255')]
    public $title;

    public $subtitle;

    public $description;

    public $link;

    public $bg_color;

    public $embeded_video;

    #[Validate('required')]
    public $image;

    public function render()
    {
        abort_if(Gate::denies('slider create'), 403);

        return view('livewire.admin.slider.create');
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

        if ( ! $this->image) {
            $this->image = null;
        } elseif (is_object($this->image) && method_exists($this->image, 'extension')) {
            $imageName = Str::slug($this->title).'.'.$this->image->extension();

            $this->slider->image = $imageName;
        }

        Slider::create($this->all());

        $this->alert('success', __('Slider created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->createModal = false;
    }
}
