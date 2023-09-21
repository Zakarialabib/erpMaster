<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use App\Imports\CategoriesImport;
use Illuminate\Support\Facades\Gate;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class Import extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $file;

    /** @var bool */
    public $importModal = false;

    #[On('importModal')]
    public function importModal(): void
    {
        abort_if(Gate::denies('category access'), 403);

        $this->importModal = true;
    }

    public function downloadSample()
    {
        return Storage::disk('exports')->download('categories_import_sample.xls');
    }

    public function import(): void
    {
        abort_if(Gate::denies('category access'), 403);

        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv,txt',
        ]);

        $file = $this->file('file');

        Excel::import(new CategoriesImport(), $file);

        $this->alert('success', __('Categories imported successfully.'));

        $this->importModal = false;
    }

    public function render()
    {
        return view('livewire.admin.categories.import');
    }
}
