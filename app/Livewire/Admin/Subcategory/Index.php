<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Subcategory;

use App\Livewire\Utils\Admin\HasDelete;
use App\Models\Subcategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Utils\Datatable;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;
    use HasDelete;

    public $subcategory;

    public $image;

    public $model = Subcategory::class;

    public function render(): View|Factory
    {
        $query = Subcategory::with('category')->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $subcategories = $query->paginate($this->perPage);

        return view('livewire.admin.subcategory.index', ['subcategories' => $subcategories]);
    }

 
}
