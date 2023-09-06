<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Section;

use App\Livewire\Utils\Datatable;
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

    public $image;

    public $section;

    public $listeners = [
        'showModal',  'delete',
    ];

    public $showModal = false;

    public $deleteModal = false;

    public $language_id;

    protected $rules = [
        'section.language_id' => 'required',
        'section.page_id'     => 'required',
        'section.title'       => 'nullable',
        'section.subtitle'    => 'nullable',
        'section.description' => 'nullable',
    ];

    public function mount()
    {
        $this->orderable = (new Section())->orderable;
    }

    public function render()
    {
        $query = Section::when($this->language_id, function ($query) {
            return $query->where('language_id', $this->language_id);
        })->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $sections = $query->paginate($this->perPage);

        return view('livewire.admin.section.index', compact('sections'));
    }

    public function delete()
    {
        // abort_if(Gate::denies('section_delete'), 403);

        Section::findOrFail($this->section)->delete();

        $this->alert('success', __('Section deleted successfully.'));
    }

    public function deleteSelected()
    {
        // abort_if(Gate::denies('section_delete'), 403);

        Section::whereIn('id', $this->selected)->delete();

        $this->resetSelected();

        $this->alert('success', __('Section deleted successfully.'));
    }

    public function confirmed()
    {
        $this->dispatch('delete');
    }

    public function deleteModal($section)
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
    public function clone(Section $section)
    {
        $section_details = Section::find($section->id);

        Section::create([
            'language_id' => $section_details->language_id,
            'page'        => $section_details->page,
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
