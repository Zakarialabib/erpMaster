@section('title', __('Purchase Details'))

@extends('layouts.print')

@section('content')
    <div class="container">

        <x-print-header :entity="$supplier" :sale="$purchase" style="centered" template="classic" :logo="$logo" />

        <br>

        <div style="margin-top: 20px;">
            <table style="{{ config('invoice.templates.classic.table.style') }}">
                <thead>
                    <tr>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Net Unit Price') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Discount') }}</th>
                        <th>{{ __('Tax') }}</th>
                        <th>{{ __('Sub Total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase->purchaseDetails as $item)
                        <tr>
                            <td>
                                {{ $item->name }} <br>
                                <span class="badge badge-success">
                                    {{ $item->code }}
                                </span>
                            </td>

                            <td>{{ format_currency($item->unit_price) }}</td>

                            <td>
                                {{ $item->quantity }}
                            </td>

                            <td>
                                {{ format_currency($item->product_discount_amount) }}
                            </td>

                            <td>
                                {{ format_currency($item->product_tax_amount) }}
                            </td>

                            <td>
                                {{ format_currency($item->sub_total) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <x-printFooter style="classic">

                @if ($purchase->discount_percentage)
                    <tr>
                        <td class="left">
                            <strong>{{ __('Discount') }}
                                ({{ $purchase->discount_percentage }}%)
                            </strong>
                        </td>
                        <td class="right">{{ format_currency($purchase->discount_amount) }}
                        </td>
                    </tr>
                @endif
                @if ($purchase->tax_percentage)
                    <tr>
                        <td class="left"><strong>{{ __('Tax') }}
                                ({{ $purchase->tax_percentage }}%)</strong>
                        </td>
                        <td class="right">{{ format_currency($purchase->tax_amount) }}</td>
                    </tr>
                @endif
                @if (settings('show_shipping') == true)
                    <tr>

                        <td class="left"><strong>{{ __('Shipping') }}</strong></td>
                        <td class="right">{{ format_currency($purchase->shipping_amount) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="left"><strong>{{ __('Grand Total') }}</strong></td>
                    <td class="right">
                        <strong>{{ format_currency($purchase->total_amount) }}</strong>
                    </td>
                </tr>
            </x-printFooter>
        </div>
    </div>
@endsection
