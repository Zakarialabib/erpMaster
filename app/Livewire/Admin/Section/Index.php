<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Section;

use App\Models\Section;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Livewire\Utils\Datatable;

class Index extends Component
{
    use LivewireAlert;
    use Datatable;
    use WithFileUploads;

    public $image;

    public $section;

    public $listeners = [
        'refreshIndex' => '$refresh',
        'showModal',  'delete',
    ];

    public $showModal = false;

    public $deleteModal = false;


    public $language_id;

   

    protected $rules = [
        'section.language_id' => 'required',
        'section.page'        => 'required',
        'section.title'       => 'nullable',
        'section.subtitle'    => 'nullable',
        'section.description' => 'nullable',
    ];

    public function confirmed()
    {
        $this->emit('delete');
    }

    public function mount()
    {
    
        $this->orderable = (new Section())->orderable;
    }

    public function render(): View|Factory
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

    // Section  Delete
    public function delete()
    {
        abort_if(Gate::denies('section_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Section::findOrFail($this->section)->delete();

        $this->alert('warning', __('Section Deleted successfully!'));
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
