<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Exports\ProductExport;
use App\Livewire\Utils\Datatable;
use App\Models\Product;
use App\Models\ProductWarehouse;
use App\Notifications\ProductTelegram;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    use Datatable;

    /** @var mixed */
    public $productWarehouse;

    /** @var array<string> */
    public $listeners = [
        'sendTelegram',
        'downloadAll', 'exportAll',
    ];

    public $importModal = false;

    public $sendTelegram;

    public $promoAllProducts;

    public $copyPriceToOldPrice;

    public $copyOldPriceToPrice;

    public $percentageMethod;

    public $percentage;

    public $product;

    public $model = Product::class;

    public function deleteModal($product): void
    {
        $confirmationMessage = __('Are you sure you want to delete this product? if something happens you can be recover it.');

        $this->confirm($confirmationMessage, [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);

        $this->product = $product;
    }

    public function deleteSelectedModal(): void
    {
        $confirmationMessage = __('Are you sure you want to delete the selected products? items can be recovered.');

        $this->confirm($confirmationMessage, [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'deleteSelected',
        ]);
    }

    #[On('deleteSelected')]
    public function deleteSelected(): void
    {
        abort_if(Gate::denies('product delete'), 403);

        Product::whereIn('id', $this->selected)->delete();
        ProductWarehouse::whereIn('product_id', $this->selected)->delete();

        $deletedCount = count($this->selected);

        if ($deletedCount > 0) {
            $this->alert(
                'success',
                __(':count selected products and related warehouses deleted successfully! These items can be recovered.', ['count' => $deletedCount])
            );
        }

        $this->resetSelected();
    }

    #[On('delete')]
    public function delete(): void
    {
        abort_if(Gate::denies('product delete'), 403);

        $product = Product::findOrFail($this->product);
        $productWarehouse = ProductWarehouse::where('product_id', $product->id)->first();

        if ($productWarehouse) {
            $productWarehouse->delete();
        }

        $product->delete();
        $this->alert('success', __('Product and related warehouse deleted successfully!'));
    }

    public function render()
    {
        abort_if(Gate::denies('product access'), 403);

        $query = Product::query()
            ->with([
                'warehouses' => static function ($query): void {
                    $query->withPivot('qty', 'price', 'cost');
                },
                'category',
                'brand',
                'movements',
            ])->select('products.*')
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        $products = $query->paginate($this->perPage);

        return view('livewire.admin.products.index', ['products' => $products]);
    }

    public function sendTelegram($product): void
    {
        $this->productWarehouse = ProductWarehouse::find($product->id);

        // Specify Telegram channel
        $telegramChannel = settings('telegram_channel');

        // Pass in product details
        $productName = $this->productWarehouse->product->name;
        $productPrice = $this->productWarehouse->price;

        $this->product->notify(new ProductTelegram($telegramChannel, $productName, $productPrice));
    }

    public function downloadAll(): BinaryFileResponse
    {
        abort_if(Gate::denies('product access'), 403);

        return $this->callExport()->download('products.xlsx');
    }

    public function exportSelected(): BinaryFileResponse
    {
        abort_if(Gate::denies('product access'), 403);

        // $customers = Product::whereIn('id', $this->selected)->get();

        return $this->callExport()->forModels($this->selected)->download('products.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

    public function exportAll(): BinaryFileResponse
    {
        abort_if(Gate::denies('product access'), 403);

        return $this->callExport()->download('products.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

    private function callExport(): ProductExport
    {
        return new ProductExport();
    }

    public function downloadSelected()
    {
        $products = Product::whereIn('id', $this->selected)->get();

        return (new ProductExport($products))->download('products.xls', \Maatwebsite\Excel\Excel::XLS);
    }

    public function promoAllProducts(): void
    {
        $this->promoAllProducts = true;
    }

    public function discountSelected(): void
    {
        $warehouseProducts = ProductWarehouse::whereIn('product_id', $this->selected)->get();

        foreach ($warehouseProducts as $warehouse) {
            if ($this->copyPriceToOldPrice) {
                $warehouse->old_price = $warehouse->price;
            } elseif ($this->copyOldPriceToPrice) {
                $warehouse->price = $warehouse->old_price;
                $warehouse->old_price = null;
            } elseif ($this->percentageMethod === '+') {
                $warehouse->price = round((float) $warehouse->price * (1 + $this->percentage / 100));
            } else {
                $warehouse->price = round((float) $warehouse->price * (1 - $this->percentage / 100));
            }

            $warehouse->save();
        }

        $this->alert('success', __('Product Prices changed successfully!'));

        $this->resetSelected();

        $this->promoAllProducts = false;

        $this->copyPriceToOldPrice = '';
        $this->copyOldPriceToPrice = '';
        $this->percentage = '';
    }
}
