<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Order;

use App\Models\Customer;
use App\Models\Order;
use Livewire\Component;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class InvoicePrint extends Component
{
    public function mount($id)
    {
        $order = Order::where('id', $id)->firstOrFail();

        $customer = Customer::where('id', $order->customer->id)->firstOrFail();

        $data = [
            'order'    => $order,
            'customer' => $customer,
            'logo'     => $this->getCompanyLogo(),
        ];

        $pdf = PDF::loadView('pdf.order-print', $data, [], [
            'format' => 'a5',
        ]);

        $fileName = __('Order').$order->reference.'.pdf';

        return $pdf->download($fileName);
    }

    private function getCompanyLogo(): string
    {
        return 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('images/logo.png')));
    }

    private function setWaterMark($model)
    {
        return $model && $model->status ? $model->status : '';
    }

    public function render()
    {
        return view('livewire.admin.order.invoice-print');
    }
}
