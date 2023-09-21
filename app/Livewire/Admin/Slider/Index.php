<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Slider;

use App\Livewire\Utils\Datatable;
use App\Models\Slider;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;
    use WithFileUploads;

    public $slider;

    public $image;

    public $listeners = [
        'showModal', 'delete',
    ];

    public $showModal = false;

    public $model = Slider::class;

    public function render()
    {
        abort_if(Gate::denies('slider access'), 403);

        $query = Slider::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $sliders = $query->paginate($this->perPage);

        return view('livewire.admin.slider.index', ['sliders' => $sliders]);
    }

    public function setFeatured($id): void
    {
        Slider::where('featured', '=', true)->update(['featured' => false]);
        $slider = Slider::findOrFail($id);
        $slider->featured = true;
        $slider->save();

        $this->alert('success', __('Slider featured successfully!'));
    }

    public function showModal(Slider $slider): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->slider = $slider;

        $this->showModal = true;
    }

    public function delete(Slider $slider): void
    {
        abort_if(Gate::denies('slider delete'), 403);

        $slider->delete();

        $this->alert('success', __('Slider deleted successfully.'));
    }
}
