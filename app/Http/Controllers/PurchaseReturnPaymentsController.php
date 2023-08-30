<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnPayment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PurchaseReturnPaymentsController extends Controller
{
    public function index($purchase_return_id)
    {
        abort_if(Gate::denies('access_purchase_return_payments'), 403);

        $purchase_return = PurchaseReturn::findOrFail($purchase_return_id);

        return view('purchasesreturn::payments.index', compact('purchase_return'));
    }

    public function create($purchase_return_id)
    {
        abort_if(Gate::denies('access_purchase_return_payments'), 403);

        $purchase_return = PurchaseReturn::findOrFail($purchase_return_id);

        return view('purchasesreturn::payments.create', compact('purchase_return'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('access_purchase_return_payments'), 403);

        $request->validate([
            'date'               => 'required|date',
            'reference'          => 'required|string|max:255',
            'amount'             => 'required|numeric',
            'note'               => 'nullable|string|max:1000',
            'purchase_return_id' => 'required',
            'payment_method'     => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            PurchaseReturnPayment::create([
                'date'               => $request->date,
                'reference'          => $request->reference,
                'amount'             => $request->amount,
                'note'               => $request->note,
                'purchase_return_id' => $request->purchase_return_id,
                'payment_method'     => $request->payment_method,
            ]);

            $purchase_return = PurchaseReturn::findOrFail($request->purchase_return_id);

            $due_amount = $purchase_return->due_amount - $request->amount;

            if ($due_amount === $purchase_return->total_amount) {
                $payment_status = PaymentStatus::DUE;
            } elseif ($due_amount > 0) {
                $payment_status = PaymentStatus::PARTIAL;
            } else {
                $payment_status = PaymentStatus::PAID;
            }

            $purchase_return->update([
                'paid_amount'    => ($purchase_return->paid_amount + $request->amount) * 100,
                'due_amount'     => $due_amount * 100,
                'payment_status' => $payment_status,
            ]);
        });

        // toast('Purchase Return Payment Created!', 'success');

        return redirect()->route('purchase-returns.index');
    }

    public function edit($purchase_return_id, PurchaseReturnPayment $purchaseReturnPayment)
    {
        abort_if(Gate::denies('access_purchase_return_payments'), 403);

        $purchase_return = PurchaseReturn::findOrFail($purchase_return_id);

        return view('purchasesreturn::payments.edit', compact('purchaseReturnPayment', 'purchase_return'));
    }

    public function update(Request $request, PurchaseReturnPayment $purchaseReturnPayment)
    {
        abort_if(Gate::denies('access_purchase_return_payments'), 403);

        $request->validate([
            'date'               => 'required|date',
            'reference'          => 'required|string|max:255',
            'amount'             => 'required|numeric',
            'note'               => 'nullable|string|max:1000',
            'purchase_return_id' => 'required',
            'payment_method'     => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $purchaseReturnPayment) {
            $purchase_return = $purchaseReturnPayment->purchaseReturn;

            $due_amount = $purchase_return->due_amount + $purchaseReturnPayment->amount - $request->amount;

            if ($due_amount === $purchase_return->total_amount) {
                $payment_status = PaymentStatus::DUE;
            } elseif ($due_amount > 0) {
                $payment_status = PaymentStatus::PARTIAL;
            } else {
                $payment_status = PaymentStatus::PAID;
            }

            $purchase_return->update([
                'paid_amount'    => ($purchase_return->paid_amount - $purchaseReturnPayment->amount + $request->amount) * 100,
                'due_amount'     => $due_amount * 100,
                'payment_status' => $payment_status,
            ]);

            $purchaseReturnPayment->update([
                'date'               => $request->date,
                'reference'          => $request->reference,
                'amount'             => $request->amount,
                'note'               => $request->note,
                'purchase_return_id' => $request->purchase_return_id,
                'payment_method'     => $request->payment_method,
            ]);
        });

        // toast('Purchase Return Payment Updated!', 'info');

        return redirect()->route('purchase-returns.index');
    }

    public function destroy(PurchaseReturnPayment $purchaseReturnPayment)
    {
        abort_if(Gate::denies('access_purchase_return_payments'), 403);

        $purchaseReturnPayment->delete();

        // toast('Purchase Return Payment Deleted!', 'warning');

        return redirect()->route('purchase-returns.index');
    }
}
