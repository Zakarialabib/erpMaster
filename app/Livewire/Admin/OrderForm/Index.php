<?php

declare(strict_types=1);

namespace App\Livewire\Admin\OrderForm;

use App\Models\OrderForms;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Utils\Datatable;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;

    public array $listsForFields = [];

    public $model = OrderForms::class;

    public function render(): View|Factory
    {
        $query = OrderForms::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $orderforms = $query->paginate($this->perPage);

        return view('livewire.admin.order-form.index', ['orderforms' => $orderforms]);
    }
}
