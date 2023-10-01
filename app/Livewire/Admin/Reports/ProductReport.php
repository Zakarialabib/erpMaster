<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class ProductReport extends Component
{
    public function render()
    {
        return view('livewire.admin.reports.product-report');
    }
}
