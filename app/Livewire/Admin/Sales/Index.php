<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sales;

use App\Imports\SaleImport;
use App\Livewire\Utils\Admin\WithModels;
use App\Models\Sale;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Utils\Datatable;
use Livewire\Attributes\Layout;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use Datatable;
    use WithModels;

    /** @var Sale|null */
    public $sale;

    /** @var array<string> */
    public $listeners = [
        'importModal',   'delete',
    ];

    public $startDate;
    public $endDate;

    public $importModal = false;

    /** @var array */
    protected $rules = [
        'customer_id'         => 'required|numeric',
        'reference'           => 'required|string|max:255',
        'tax_percentage'      => 'required|string|min:0|max:100',
        'discount_percentage' => 'required|string|min:0|max:100',
        'shipping_amount'     => 'required|numeric',
        'total_amount'        => 'required|numeric',
        'paid_amount'         => 'required|numeric',
        'status'              => 'required|integer|min:0|max:100',
        'payment_method'      => 'required|integer|min:0|max:100',
        'note'                => 'string|nullable|max:1000',
    ];

    public function mount(): void
    {
        $this->orderable = (new Sale())->orderable;
        $this->startDate = now()->startOfYear()->format('Y-m-d');
        $this->endDate = now()->endOfDay()->format('Y-m-d');
    }

    public function filterByType($type)
    {
        switch ($type) {
            case 'day':
                $this->startDate = now()->startOfDay()->format('Y-m-d');
                $this->endDate = now()->endOfDay()->format('Y-m-d');

                break;
            case 'month':
                $this->startDate = now()->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->endOfMonth()->format('Y-m-d');

                break;
            case 'year':
                $this->startDate = now()->startOfYear()->format('Y-m-d');
                $this->endDate = now()->endOfYear()->format('Y-m-d');

                break;
        }
    }

    public function render()
    {
        abort_if(Gate::denies('sale access'), 403);

        $query = Sale::with(['customer', 'user', 'saleDetails', 'salepayments', 'saleDetails.product'])
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        $sales = $query->paginate($this->perPage);

        return view('livewire.admin.sales.index', compact('sales'));
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('sale delete'), 403);

        Sale::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Sale $sale)
    {
        abort_if(Gate::denies('sale delete'), 403);

        $sale->delete();

        $this->dispatch('refreshIndex');

        $this->alert('success', __('Sale deleted successfully.'));
    }

    public function importModal()
    {
        abort_if(Gate::denies('sale create'), 403);

        $this->importModal = true;
    }

    public function downloadSample(): BinaryFileResponse
    {
        return Storage::disk('exports')->download('sales_import_sample.xls');
    }

    public function import()
    {
        abort_if(Gate::denies('sale create'), 403);

        $this->validate([
            'import_file' => [
                'required',
                'file',
            ],
        ]);

        Sale::import(new SaleImport(), $this->file('import_file'));

        $this->alert('success', __('Sales imported successfully'));

        $this->dispatch('refreshIndex');

        $this->importModal = false;
    }

    public function sendWhatsapp($sale)
    {
        $this->sale = Sale::find($sale);

        // Get the customer's phone number and due amount from the model.
        $phone = $this->sale->customer->phone;
        $name = $this->sale->customer->name;

        $dueAmount = format_currency($this->sale->due_amount);

        // Delete the leading zero from the phone number, if it exists.
        if (strpos($phone, '0') === 0) {
            $phone = substr($phone, 1);
        }

        // Add the country code to the beginning of the phone number.
        $phone = '+212'.$phone;

        $greeting = __('Hello');

        $message = __('You have a due amount of');

        // Construct the message text.
        $message = "{$greeting} {$name} {$message} {$dueAmount}.";

        // Encode the message text for use in the URL.
        $message = urlencode($message);

        // Construct the WhatsApp API endpoint URL.
        $url = "https://api.whatsapp.com/send?phone={$phone}&text={$message}";

        return redirect()->away($url);
    }

    public function openWhatapp($url)
    {
        // open whatsapp url in another tab
    }
}
