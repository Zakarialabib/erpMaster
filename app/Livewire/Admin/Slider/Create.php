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

    #[Rule('required|max:255')]
    public $title;
    #[Rule('nullable')]
    public $subtitle;
    #[Rule('nullable')]
    public $description;
    #[Rule('nullable')]
    public $link;
    #[Rule('nullable')]
    public $bg_color;
    #[Rule('nullable')]
    public $embeded_video;
    #[Rule('required')]
    public $image;

    public function render()
    {
        abort_if(Gate::denies('slider create'), 403);

        return view('livewire.admin.slider.create');
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
