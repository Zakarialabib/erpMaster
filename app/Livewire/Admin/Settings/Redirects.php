<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Settings;

use App\Models\Redirect;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Livewire\Utils\Datatable;

class Redirects extends Component
{
    use LivewireAlert;
    use Datatable;

    public $listeners = ['delete'];

    public $editModal = false;

    public $redirect;

    protected $rules = [
        'redirect.old_url' => 'required',
        'redirect.new_url' => 'nullable',
    ];

    public function mount()
    {
        $this->orderable = (new Redirect())->orderable;
    }

    #[On('editModal')]
    public function editModal($id)
    {
        $this->redirect = Redirect::find($id);
        $this->editModal = true;
    }

    public function update()
    {
        $this->validate();

        $this->redirect->save();

        $this->alert('warning', __('Redirect updated successfully!'));

        $this->editModal = false;
    }

    public function delete(Redirect $redirect)
    {
        $redirect->delete();

        $this->alert('warning', __('Redirect deleted successfully!'));
    }

    public function render(): View|Factory
    {
        $query = Redirect::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $redirects = $query->paginate($this->perPage);

        return view('livewire.admin.settings.redirects', ['redirects' => $redirects]);
    }
}
