<div>

    <div class="py-10">
        <h2 class="text-2xl font-bold font-heading text-gray-700 mb-4">{{ __('Orders') }}</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse ($orders as $order)
                <div class="px-4 py-6 shadow-lg border bg-white rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-gray-700 font-bold">{{ __('Reference') }}:</p>
                        <p class="text-gray-600">{{ $order->reference }}</p>
                    </div>

                    @if ($order->product)
                        <div class="flex justify-between items-center mb-4">
                            <p class="text-gray-700 font-bold">{{ __('Product') }}:</p>
                            <p class="text-gray-600">
                                <a
                                    href="{{ route('front.product', $order->product->slug) }}">{{ $order->product->name }}</a>
                            </p>
                        </div>
                    @endif
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-gray-700 font-bold">{{ __('Order Amount') }}:</p>
                        <p class="text-gray-600">{{ format_currency($order->amount) }}</p>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-gray-700 font-bold">{{ __('Payment Method') }}:</p>
                        <p class="text-gray-600">{{ $order->payment_method }}</p>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-gray-700 font-bold">{{ __('Order Status') }}:</p>
                        <p class="text-gray-600">{{ $order->status->label() }}</p>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-gray-700 font-bold">{{ __('Payment Status') }}:</p>
                        <p class="text-gray-600">{{ $order->payment_status->label() }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-700 font-bold">{{ __('Order Date') }}:</p>
                        <p class="text-gray-600">{{ format_date($order->created_at) }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full px-4 py-6 shadow-lg border bg-green-50 rounded-lg">
                    <p class="text-gray-700 text-center font-bold">{{ __('No orders found') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
