<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class SalePaymentsController extends Controller
{
    public function index($sale_id)
    {
        abort_if(Gate::denies('sale payment access'), 403);

        $sale = Sale::findOrFail($sale_id);

        return view('admin.sale.payments.index', ['sale' => $sale]);
    }
}
