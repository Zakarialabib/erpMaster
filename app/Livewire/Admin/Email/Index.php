<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Email;

use App\Models\EmailTemplate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Utils\Datatable;
use Illuminate\Support\Facades\Gate;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;

    public $email;

    public $model = EmailTemplate::class;

    public function render(): View|Factory
    {
        abort_if(Gate::denies('email access'), 403);

        $query = EmailTemplate::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $emails = $query->paginate($this->perPage);

        return view('livewire.admin.email.index', ['emails' => $emails]);
    }

    // Blog Category  Delete
    public function delete(EmailTemplate $email): void
    {
        abort_if(Gate::denies('email delete'), 403);

        $email->delete();
    }
}
