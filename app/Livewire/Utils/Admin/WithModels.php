<?php

declare(strict_types=1);

namespace App\Livewire\Utils\Admin;

use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Warehouse;
use Livewire\Attributes\Computed;

trait WithModels
{
    #[Computed(cache: true)]
    public function customers()
    {
        return Customer::pluck('name', 'id')->toArray();
    }
 
    #[Computed(cache: true)]
    public function suppliers()
    {
        return Supplier::pluck('name', 'id')->toArray();
    }

    #[Computed(cache: true)]
    public function warehouses()
    {
        return Warehouse::pluck('name', 'id')->toArray();
    }
}
