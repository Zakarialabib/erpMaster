<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\SaleReturn;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $sales = Sale::completed()->sum('total_amount');
        $sale_returns = SaleReturn::completed()->sum('total_amount');
        $purchase_returns = PurchaseReturn::completed()->sum('total_amount');

        $product_costs = 0;

        foreach (Sale::completed()->with('saleDetails.product')->get() as $sale) {
            foreach ($sale->saleDetails as $saleDetail) {
                $product_costs += $saleDetail->product?->cost;
            }
        }

        $revenue = ($sales - $sale_returns) / 100;
        $profit = $revenue - $product_costs;

        $data = [
            'today' => [
                'salesTotal' => Sale::salesTotal(Carbon::now()),
                'stockValue' => Product::stockValue(Carbon::now()),
            ],
            'month' => [
                'salesTotal' => Sale::salesTotal(Carbon::now()->subMonth()),
                'stockValue' => Product::stockValue(Carbon::now()->subMonth()),
            ],
            'semi' => [
                'salesTotal' => Sale::salesTotal(Carbon::now()->subMonths(6)),
                'stockValue' => Product::stockValue(Carbon::now()->subMonths(6)),
            ],
            'year' => [
                'salesTotal' => Sale::salesTotal(Carbon::now()->subYear()),
                'stockValue' => Product::stockValue(Carbon::now()->subYear()),
            ],
        ];

        return view('admin.home', [
            'revenue'          => $revenue,
            'sale_returns'     => $sale_returns / 100,
            'purchase_returns' => $purchase_returns / 100,
            'profit'           => $profit,
            'data'             => $data,
        ]);
    }
}
