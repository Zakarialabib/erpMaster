@section('title', __('Order Details'))

@extends('layouts.print')

@section('content')
    <div class="container">
        <x-print-header :entity="$customer" :sale="$order" style="centered" template="modern" :logo="$logo" />
        <br>
        <div style="margin-top: 20px;">
            <table style="border-collapse:collapse">
                <thead>
                    <tr class="title">
                        <th colspan="2" style="text-align: left;">{{ __('Product information') }}</th>
                        <th colspan="2" style="text-align: right;">{{ __('Qty') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $orderDetail)
                        <tr>
                            <td colspan="2" style="text-align: left;">
                                {{ $orderDetail->product->name }} <br>
                                <small><strong>{{ format_currency($orderDetail->price) }}</strong></small>
                            </td>
                            <td colspan="2" style="text-align: right;">
                                {{ $orderDetail->quantity }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col">
                <table>
                    <tbody>
                        @if (settings('show_order_tax') == true)
                            <tr>
                                <th colspan="3" style="text-align:left">{{ __('Tax') }}</th>
                                <th style="text-align:right">{{ format_currency($order->tax_amount) }}</th>
                            </tr>
                        @endif
                        @if (settings('show_discount') == true)
                            <tr>
                                <th colspan="3" style="text-align:left">{{ __('Discount') }}</th>
                                <th style="text-align:right">{{ format_currency($order->discount_amount) }}</th>
                            </tr>
                        @endif
                        @if (settings('show_shipping') == true)
                            <tr>
                                <th colspan="3" style="text-align:left">{{ __('Shipping') }}</th>
                                <th style="text-align:right">{{ format_currency($order->shipping_amount) }}</th>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="3" style="text-align:left">{{ __('Grand Total') }}</th>
                            <th style="text-align:right">{{ format_currency($order->total_amount) }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
