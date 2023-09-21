<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Reviews;

use App\Models\Review;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Utils\Datatable;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;

    public $model = Review::class;

    public function render(): View|Factory
    {
        $query = Review::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $reviews = $query->paginate($this->perPage);

        return view('livewire.admin.reviews.index', ['reviews' => $reviews]);
    }
}
