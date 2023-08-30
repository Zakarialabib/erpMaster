<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Suppliers;

use App\Livewire\Utils\Datatable;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use Livewire\Component;

class Details extends Component
{
    use Datatable;

    public $supplier_id;

    /** @var mixed */
    public $supplier;

    public function mount($supplier): void
    {
        $this->supplier = $supplier;
        $this->supplier_id = $this->supplier->id;
        $this->selectPage = false;
        $this->orderable = (new Supplier())->orderable;
    }

    public function getTotalPurchasesProperty()
    {
        return $this->supplierSum('total_amount');
    }

    public function getTotalPurchaseReturnsProperty()
    {
        return PurchaseReturn::where('supplier_id', $this->supplier_id)
            ->sum('total_amount');
    }

    // total due amount
    public function getTotalDueProperty()
    {
        return $this->supplierSum('due_amount');
    }

    // show totalPayments
    public function getTotalPaymentsProperty()
    {
        return $this->supplierSum('paid_amount');
    }

    // show Debit
    public function getDebitProperty()
    {
        $purchases = Purchase::where('supplier_id', $this->supplier_id)
            ->completed()->sum('total_amount');
        $purchase_returns = PurchaseReturn::where('supplier_id', $this->supplier_id)
            ->completed()->sum('total_amount');

        $product_costs = 0;

        foreach (Purchase::completed()->with('purchaseDetails', 'purchaseDetails.product')->get() as $purchase) {
            foreach ($purchase->purchaseDetails as $purchaseDetail) {
                $product_costs += $purchaseDetail->product->cost;
            }
        }

        $debt = ($purchases - $purchase_returns) / 100;

        return $debt - $product_costs;
    }

    public function getPurchasesProperty(): mixed
    {
        $query = Purchase::where('supplier_id', $this->supplier_id)
            ->with('supplier')
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        return $query->paginate($this->perPage);
    }

    public function getSupplierPaymentsProperty(): mixed
    {
        $query = Purchase::where('supplier_id', $this->supplier_id)
            ->with('purchasepayments.purchase')
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.suppliers.details');
    }

    private function supplierSum(string $field): int|float
    {
        return Purchase::whereBelongsTo($this->supplier)->sum($field) / 100;
    }
}
