<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Faq;

use App\Models\Faq;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Utils\Datatable;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;

    public $faq;

    public function mount()
    {
        $this->orderable = (new Faq())->orderable;
    }

    public function render(): View|Factory
    {
        $query = Faq::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $faqs = $query->paginate($this->perPage);

        return view('livewire.admin.faq.index', compact('faqs'));
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('category_delete'), 403);

        Faq::whereIn('id', $this->selected)->delete();

        $this->alert('success', __('Faq deleted successfully.'));

        $this->resetSelected();
    }

    public function delete(Faq $faq)
    {
        abort_if(Gate::denies('faq_delete'), 403);

        $faq->delete();

        $this->alert('success', __('Faq deleted successfully.'));
    }
}
