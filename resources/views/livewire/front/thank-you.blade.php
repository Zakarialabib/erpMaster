<div>
    @section('title', __('Thank you ') . $order?->user?->fullName ?? '')

    <section class="relative py-10 bg-gray-100">
        <div class="mx-auto px-16 mb-6">
            <h2 class="mb-8 text-5xl text-center font-bold font-heading">{{ __('Thank you') }}
                @if (!empty($order->user))
                    {{ $order->user->fullName }}
                @endif
            </h2>

            <div class="flex items-center bg-white my-6 py-10">

                <div class="w-full px-10 mb-4">
                    <div class="flex flex-wrap gap-6 justify-between mb-6">
                        <div class="flex-1 w-full md:w-auto">
                            <h4 class="mb-6 font-bold font-heading">{{ __('Delivery Address') }}</h4>
                            <p>{{ __('Address') }}
                                <span class="text-gray-500">
                                    {{ $order->customer->address }}
                                </span>
                            </p>
                            <p class="text-gray-500">{{ $order->customer->city }} -
                                {{ $order->customer->country }}
                            </p>
                        </div>
                        <div class="flex-1 w-full md:w-auto">
                            <h4 class="mb-6 font-bold font-heading">{{ __('Your order is processing') }}</h4>

                            <p>{{ __('Reference') }}
                                <span class="text-gray-500">
                                    {{ $order->reference }}
                                </span>
                            </p>

                            <p>{{ __('Date') }}
                                <span class="text-gray-500">
                                    {{ $order->created_at->format('d/m/Y') }}
                                </span>
                            </p>
                        </div>
                        <div class="flex-1 w-full md:w-auto">
                            <h4 class="mb-6 font-bold font-heading">{{ __('Shipping informations') }}</h4>
                            <p>{{ __('Email') }}
                                <span class="text-gray-500">
                                    {{ $order->customer->email }}
                                </span>
                            </p>
                            <p>{{ __('Phone') }}
                                <span class="text-gray-500">
                                    {{ $order->customer->phone }}
                                </span>
                            </p>
                        </div>
                    </div>



                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr
                                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-4 py-3">{{ __('Product Image') }}</th>
                                        <th class="px-4 py-3">{{ __('Product ') }}Name</th>
                                        <th class="px-4 py-3">{{ __('Quantity') }}</th>
                                        <th class="px-4 py-3">{{ __('Price') }}</th>
                                        <th class="px-4 py-3">{{ __('Subtotal') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @foreach ($order->orderDetails as $item)
                                        <tr class="text-gray-700">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center text-sm">
                                                    <div>
                                                        <img class="w-10 h-10 rounded-full"
                                                            src="{{ asset('images/products/' . $item->product->image) }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm">{{ $item->name }}</td>
                                            <td class="px-4 py-3 text-sm">{{ $item->quantity }}</td>
                                            <td class="px-4 py-3 text-sm">{{ format_currency($item->price) }}</td>
                                            <td class="px-4 py-3 text-sm">
                                                {{ format_currency($item->quantity * $item->price) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-5 border-t border-black w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-no-wrap">
                                <tbody class="bg-white divide-y">
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 text-sm">{{ __('Shipping') }}</td>
                                        <td class="px-4 py-3 text-sm">{{ format_currency($order->shipping->cost) }}
                                        </td>
                                    </tr>
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 text-sm">{{ __('Order Total') }}</td>
                                        <td class="px-4 py-3 text-sm">{{ format_currency($order->total_amount) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <a class="block text-center px-8 py-4 bg-red-500 hover:bg-red-700 text-white font-bold font-heading uppercase rounded-md transition duration-200"
                href="{{ route('front.index') }}">
                {{ __('Go back Shopping') }}
            </a>
        </div>
    </section>
</div>
