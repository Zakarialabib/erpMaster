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

    public $model = Section::class;

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

    public function render()
    {
        $query = Section::when($this->language_id, fn ($query) => $query->where('language_id', $this->language_id))->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $sections = $query->paginate($this->perPage);

        return view('livewire.admin.section.index', ['sections' => $sections]);
    }

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
