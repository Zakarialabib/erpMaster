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
use Livewire\Attributes\On;

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

    #[On('delete')]
    public function delete(): void
    {
        // abort_if(Gate::denies('slider_delete'), 403);

        Slider::findOrFail($this->slider)->delete();

        $this->alert('success', __('Slider deleted successfully.'));
    }

    public function deleteSelected(): void
    {
        // abort_if(Gate::denies('slider_delete'), 403);

        Slider::whereIn('id', $this->selected)->delete();

        $this->resetSelected();

        $this->alert('success', __('Slider deleted successfully.'));
    }

    public function confirmed(): void
    {
        $this->dispatch('delete');
    }

    public function deleteModal($slider): void
    {
        $this->confirm(__('Are you sure you want to delete this?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);
        $this->slider = $slider;
    }
}
