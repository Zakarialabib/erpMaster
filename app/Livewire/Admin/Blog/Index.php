<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Blog;

use App\Livewire\Utils\Admin\HasDelete;
use App\Livewire\Utils\Datatable;
use App\Models\Blog;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;
    use HasDelete;

    public $blog;
    
    public $model = Blog::class;
    
    public function render()
    {
        $query = Blog::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $blogs = $query->paginate($this->perPage);

        return view('livewire.admin.blog.index', ['blogs' => $blogs]);
    }
}
