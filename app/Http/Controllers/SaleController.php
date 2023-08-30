<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Enums\SaleStatus;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SaleController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sale_access'), 403);

        return view('admin.sale.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sale_create'), 403);

        Cart::instance('sale')->destroy();

        $product_categories = Category::select(['id', 'name'])->get();

        return view('admin.sale.create', compact('product_categories'));
    }

    public function edit(Sale $sale)
    {
        abort_if(Gate::denies('sale_update'), 403);

        $sale_details = $sale->saleDetails;

        Cart::instance('sale')->destroy();

        $cart = Cart::instance('sale');

        foreach ($sale_details as $sale_detail) {
            $cart->add([
                'id'      => $sale_detail->product_id,
                'name'    => $sale_detail->name,
                'qty'     => $sale_detail->quantity,
                'price'   => $sale_detail->price,
                'weight'  => 1,
                'options' => [
                    'product_discount'      => $sale_detail->product_discount_amount,
                    'product_discount_type' => $sale_detail->product_discount_type,
                    'sub_total'             => $sale_detail->sub_total,
                    'code'                  => $sale_detail->code,
                    'stock'                 => Product::findOrFail($sale_detail->product_id)->quantity,
                    'product_tax'           => $sale_detail->product_tax_amount,
                    'unit_price'            => $sale_detail->unit_price,
                ],
            ]);
        }

        return view('admin.sale.edit', compact('sale'));
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        DB::transaction(function () use ($request, $sale) {
            $due_amount = $request->total_amount - $request->paid_amount;

            if ($due_amount === $request->total_amount) {
                $payment_status = PaymentStatus::PENDING;
            } elseif ($due_amount > 0) {
                $payment_status = PaymentStatus::PARTIAL;
            } else {
                $payment_status = PaymentStatus::PAID;
            }

            foreach ($sale->saleDetails as $sale_detail) {
                if ($sale->status === SaleStatus::SHIPPED || $sale->status === SaleStatus::COMPLETED) {
                    $product = Product::findOrFail($sale_detail->product_id);
                    $product->update([
                        'quantity' => $product->quantity + $sale_detail->quantity,
                    ]);
                }
                $sale_detail->delete();
            }

            $sale->update([
                'date'                => $request->date,
                'reference'           => $request->reference,
                'customer_id'         => $request->customer_id,
                'tax_percentage'      => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount'     => $request->shipping_amount * 100,
                'paid_amount'         => $request->paid_amount * 100,
                'total_amount'        => $request->total_amount * 100,
                'due_amount'          => $due_amount * 100,
                'status'              => $request->status,
                'payment_status'      => $payment_status,
                'payment_method'      => $request->payment_method,
                'note'                => $request->note,
                'tax_amount'          => Cart::instance('sale')->tax() * 100,
                'discount_amount'     => Cart::instance('sale')->discount() * 100,
            ]);

            foreach (Cart::instance('sale')->content() as $cart_item) {
                SaleDetails::create([
                    'sale_id'                 => $sale->id,
                    'product_id'              => $cart_item->id,
                    'name'                    => $cart_item->name,
                    'code'                    => $cart_item->options->code,
                    'quantity'                => $cart_item->qty,
                    'price'                   => $cart_item->price * 100,
                    'unit_price'              => $cart_item->options->unit_price * 100,
                    'sub_total'               => $cart_item->options->sub_total * 100,
                    'product_discount_amount' => $cart_item->options->product_discount * 100,
                    'product_discount_type'   => $cart_item->options->product_discount_type,
                    'product_tax_amount'      => $cart_item->options->product_tax * 100,
                ]);

                if ($request->status === SaleStatus::SHIPPED || $request->status === SaleStatus::COMPLETED) {
                    $product = Product::findOrFail($cart_item->id);
                    $product->update([
                        'quantity' => $product->quantity - $cart_item->qty,
                    ]);
                }
            }

            Cart::instance('sale')->destroy();
        });

        // toast('Sale Updated!', 'info');

        return redirect()->route('sales.index');
    }
}
