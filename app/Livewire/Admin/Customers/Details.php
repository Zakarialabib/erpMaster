<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Customers;

use App\Livewire\Utils\Datatable;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleReturn;
use Livewire\Component;

class Details extends Component
{
    use Datatable;

    public $customer_id;

    public $customer;

    public function mount($customer): void
    {
        // dd($customer);
        $this->customer = $customer;
        $this->customer_id = $this->customer->id;
        $this->selectPage = false;
        $this->orderable = (new Customer())->orderable;
    }

    public function getSalesProperty(): mixed
    {
        $query = Sale::where('customer_id', $this->customer_id)
            ->with('customer')
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        return $query->paginate($this->perPage);
    }

    public function getCustomerPaymentsProperty(): mixed
    {
        $query = Sale::where('customer_id', $this->customer_id)
            ->with('salepayments.sale')
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        return $query->paginate($this->perPage);
    }

    public function getTotalSalesProperty(): int|float
    {
        return $this->customerSum('total_amount');
    }

    public function getTotalSaleReturnsProperty(): int|float
    {
        return SaleReturn::whereBelongsTo($this->customer)
            ->completed()->sum('total_amount');
    }

    public function getTotalPaymentsProperty(): int|float
    {
        return $this->customerSum('paid_amount');
    }

    // total due amount
    public function getTotalDueProperty(): int|float
    {
        return $this->customerSum('due_amount');
    }

    // show profit
    public function getProfitProperty(): int|float
    {
        $sales = Sale::where('customer_id', $this->customer_id)
            ->completed()->sum('total_amount');

        $sale_returns = SaleReturn::whereBelongsTo($this->customer)
            ->completed()->sum('total_amount');

        $product_costs = 0;

        foreach (Sale::where('customer_id', $this->customer_id)->saleDetails()->with('product')->get() as $sale) {
            foreach ($sale->saleDetails as $saleDetail) {
                $product_costs += $saleDetail->product->cost;
            }
        }

        $revenue = ($sales - $sale_returns) / 100;

        return $revenue - $product_costs;
    }

    public function render()
    {
        return view('livewire.admin.customers.details');
    }

    private function customerSum(string $field): int|float
    {
        return Sale::whereBelongsTo($this->customer)->sum($field) / 100;
    }
}
