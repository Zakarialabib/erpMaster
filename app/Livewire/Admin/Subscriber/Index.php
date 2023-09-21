<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Subscriber;

use App\Models\Subscriber;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Livewire\Utils\Datatable;

class Index extends Component
{
    use Datatable;

    public $model = Subscriber::class;

    public $subscriber;

    public function render(): View|Factory
    {
        $query = Subscriber::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $subscribers = $query->paginate($this->perPage);

        return view('livewire.admin.subscriber.index', ['subscribers' => $subscribers]);
    }
}
