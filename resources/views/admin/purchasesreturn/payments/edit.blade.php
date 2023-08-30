@extends('layouts.app')

@section('title', __('Edit Payment'))

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('purchase-returns.index') }}">Purchase Returns</a></li>
        <li class="breadcrumb-item"><a href="{{ route('purchase-returns.show', $purchase_return) }}">{{ $purchase_return->reference }}</a></li>
        <li class="breadcrumb-item active">Edit Payment</li>
    </ol>
@endsection

@section('content')
    <div class="px-4 mx-auto">
        <form id="payment-form" action="{{ route('purchase-return-payments.update', $purchaseReturnPayment) }}" method="POST">
            @csrf
            @method('patch')
            <div class="row">
                <div class="w-full px-4">
                    @include('utils.alerts')
                    <div class="mb-4">
                        <button class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded">{{__('Update Payment')}} <i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="w-full px-4">
                    <div class="card">
                        <div class="p-4">
                            <div class="flex flex-wrap -mx-2 mb-3">
                                <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                                        <label for="reference">{{__('Reference')}} <span class="text-red-500">*</span></label>
                                        <input type="text" class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1" name="reference" required readonly value="{{ $purchaseReturnPayment->reference }}">
                                </div>
                                <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                                        <label for="date">{{__('Date')}} <span class="text-red-500">*</span></label>
                                        <input type="date" class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1" name="date" required value="{{ $purchaseReturnPayment->getAttributes()['date'] }}">
                                </div>
                            
                                <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                                        <label for="due_amount">{{__('Due Amount')}} <span class="text-red-500">*</span></label>
                                        <input type="text" class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1" name="due_amount" required value="{{ format_currency($purchase_return->due_amount) }}" readonly>
                                </div>
                                <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                                    <div class="mb-4">
                                        <label for="amount">{{__('Amount')}} <span class="text-red-500">*</span></label>
                                        <div class="input-group">
                                            <input id="amount" type="text" class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1" name="amount" required value="{{ old('amount') ?? $purchaseReturnPayment->amount }}">
                                            <div class="input-group-append">
                                                <button id="getTotalAmount" class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded" type="button">
                                                    <i class="bi bi-check-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                                    <div class="from-group">
                                        <div class="mb-4">
                                            <label for="payment_method">{{__('Payment Method')}} <span class="text-red-500">*</span></label>
                                            <select class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1" name="payment_method" id="payment_method" required>
                                                <option {{ $purchaseReturnPayment->payment_method == 'Cash' ? 'selected' : '' }} value="Cash">Cash</option>
                                                <option {{ $purchaseReturnPayment->payment_method == 'Bank Transfer' ? 'selected' : '' }} value="Bank Transfer">Bank Transfer</option>
                                                <option {{ $purchaseReturnPayment->payment_method == 'Cheque' ? 'selected' : '' }} value="Cheque">Cheque</option>
                                                <option {{ $purchaseReturnPayment->payment_method == 'Other' ? 'selected' : '' }} value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="note">{{__('Note')}}</label>
                                <textarea class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1" rows="4" name="note">{{ old('note') ?? $purchaseReturnPayment->note }}</textarea>
                            </div>

                            <input type="hidden" value="{{ $purchase_return->id }}" name="purchase_return_id">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#amount').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });

            $('#amount').maskMoney('mask');

            $('#getTotalAmount').click(function () {
                $('#amount').maskMoney('mask', {{ $purchase_return->due_amount }});
            });

            $('#payment-form').submit(function () {
                var amount = $('#amount').maskMoney('unmasked')[0];
                $('#amount').val(amount);
            });
        });
    </script>
@endpush

