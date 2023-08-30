<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Customer;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Livewire\Utils\Datatable;

class Index extends Component
{
    use Datatable;

    public function mount()
    {
        $this->orderable = (new User())->orderable;
    }

    public function render(): View|Factory
    {
        $query = User::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $customers = $query->paginate($this->perPage);

        return view('livewire.admin.customer.index', compact('customers'));
    }
}
