<?php

declare(strict_types=1);

namespace App\Livewire\Utils;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use Livewire\Component;

class Livesearch extends Component
{
    public $query = '';

    public $product;

    public $customer;

    public $supplier;

    public $sale;

    public $purchase;

    protected $queryString = [
        'query',
    ];

    public function mount(): void
    {
        $this->product = Product::query()->where('name', 'LIKE', '%'.$this->query.'%')->orWhere('code', 'like', '%'.$this->query.'%')->get();

        $this->customer = Customer::query()->where('name', 'LIKE', '%'.$this->query.'%')
            ->with('sales')->get();

        $this->supplier = Supplier::query()->where('name', 'LIKE', '%'.$this->query.'%')
            ->with('purchases')->get();

        $this->sale = Sale::query()->where('reference', 'like', '%'.$this->query.'%')->get();

        $this->purchase = Purchase::query()->where('reference', 'like', '%'.$this->query.'%')->get();
    }

    public function render()
    {
        return view('livewire.utils.livesearch');
    }
}
