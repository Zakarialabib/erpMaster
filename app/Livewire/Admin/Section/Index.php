<?php

declare(strict_types=1);


namespace App\Livewire\Admin\Section;

use App\Livewire\Utils\Datatable;
use Livewire\Attributes\On;
use App\Models\Section;
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

    public $section;

    public $deleteModal = false;

    public $model = Section::class;


    public function render()
    {
        $query = Section::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $sections = $query->paginate($this->perPage);

        return view('livewire.admin.section.index', ['sections' => $sections]);
    }

    #[On('delete')]
    public function delete(): void
    {
        // abort_if(Gate::denies('section_delete'), 403);

        Section::findOrFail($this->section)->delete();

        $this->alert('success', __('Section deleted successfully.'));
    }

    public function deleteSelected(): void
    {
        // abort_if(Gate::denies('section_delete'), 403);

        Section::whereIn('id', $this->selected)->delete();

        $this->resetSelected();

        $this->alert('success', __('Section deleted successfully.'));
    }

    public function confirmed(): void
    {
        $this->dispatch('delete');
    }

    public function deleteModal($section): void
    {
        $this->confirm(__('Are you sure you want to delete this?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);
        $this->section = $section;
    }

    // Section  Clone
    public function clone(Section $section): void
    {
        $section_details = Section::find($section->id);

        Section::create([
            'language_id' => $section_details->language_id,
            'page_id'     => $section_details->page_id,
            'title'       => $section_details->title,
            'subtitle'    => $section_details->subtitle,
            'link'        => $section_details->link,
            'image'       => $section_details->image,
            'description' => $section_details->description,
            'status'      => 0,
        ]);
        $this->alert('success', __('Section Cloned successfully!'));
    }
}
