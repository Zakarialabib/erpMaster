<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Exports\ProductExport;
use App\Livewire\Utils\Datatable;
use App\Imports\ProductImport;
use App\Models\Product;
use App\Notifications\ProductTelegram;

use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Index extends Component
{
    use Datatable;
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;
    use Datatable;

    /** @var mixed */
    public $product;

    public $productIds;

    /** @var array<string> */
    public $listeners = [
        'refreshIndex' => '$refresh',
        'importModal', 'sendTelegram',
        'downloadAll', 'exportAll',
        'delete',
    ];

    public $importModal = false;

    public $sendTelegram;

    public $selectAll;

    public function mount(): void
    {
        $this->orderable = (new Product())->orderable;
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('product_delete'), 403);

        Product::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Product $product): void
    {
        abort_if(Gate::denies('product_delete'), 403);

        $product->delete();
    }

    public function render()
    {
        abort_if(Gate::denies('product_access'), 403);

        $query = Product::query()
            ->with([
                'category' => fn ($query) => $query->select('id', 'name'),
                'brand'    => fn ($query) => $query->select('id', 'name'),
                'movements',
                'warehouses',
            ])
            ->select('products.*')
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        $products = $query->paginate($this->perPage);

        return view('livewire.admin.products.index', compact('products'));
    }

    public function selectAll()
    {
        if (count(array_intersect($this->selected, Product::pluck('id')->toArray())) === count(Product::pluck('id')->toArray())) {
            $this->selected = [];
        } else {
            $this->selected = Product::pluck('id')->toArray();
        }
    }

    public function selectPage()
    {
        if (count(array_intersect($this->selected, Product::paginate($this->perPage)->pluck('id')->toArray())) === count(Product::paginate($this->perPage)->pluck('id')->toArray())) {
            $this->selected = [];
        } else {
            $this->selected = $this->productIds;
        }
    }

    public function sendTelegram($product): void
    {
        $this->product = Product::find($product);

        // Specify Telegram channel
        $telegramChannel = settings()->telegram_channel;

        // Pass in product details
        $productName = $this->product->name;
        $productPrice = $this->product->price;

        $this->product->notify(new ProductTelegram($telegramChannel, $productName, $productPrice));
    }

    public function importModal(): void
    {
        abort_if(Gate::denies('product_access'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->importModal = true;
    }

    public function downloadSample()
    {
        return Storage::disk('exports')->download('products_import_sample.xls');
    }

    public function import(): void
    {
        $this->validate([
            'import_file' => [
                'required',
                'file',
            ],
        ]);

        Product::import(new ProductImport(), $this->file('import_file'));

        $this->alert('success', __('Products imported successfully'));

        $this->importModal = false;
    }

    public function downloadAll(): BinaryFileResponse
    {
        abort_if(Gate::denies('product_access'), 403);

        return $this->callExport()->download('products.xlsx');
    }

    public function exportSelected(): BinaryFileResponse
    {
        abort_if(Gate::denies('product_access'), 403);

        // $customers = Product::whereIn('id', $this->selected)->get();

        return $this->callExport()->forModels($this->selected)->download('products.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

    public function exportAll(): BinaryFileResponse
    {
        abort_if(Gate::denies('product_access'), 403);

        return $this->callExport()->download('products.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

    private function callExport(): ProductExport
    {
        return new ProductExport();
    }
}
