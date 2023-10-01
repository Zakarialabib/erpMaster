<div>
    <section class="relative py-10 bg-gray-100">
        <div class="mx-auto px-16 mb-6">
            <h2 class="mb-8 text-5xl text-center font-bold font-heading">{{ __('Thank you') }}
                @if (!empty($order->user))
                    {{ $order->user->fullName }}
                @endif
            </h2>
            <div class="w-full flex justify-center px-10 gap-6 mb-6 text-gray-500">
                <p>{{ __('Your order is processing') }}</p>

                <p>{{ __('Order Number') }}
                    <span class="text-blue-300 font-bold font-heading">
                        {{ $order->reference }}
                    </span>
                </p>

                <p>{{ __('Date') }}
                    <span class="text-blue-300 font-bold font-heading">
                        {{ $order->created_at->format('d/m/Y') }}
                    </span>
                </p>
            </div>

            <div class="mb-4 px-10 bg-gray-100">
                <div class="flex flex-wrap gap-6 justify-between">
                    <div class="w-full md:w-auto">
                        <h4 class="mb-6 font-bold font-heading">{{ __('Delivery Address') }}</h4>
                        <p class="text-gray-500">
                            {{ $order->customer->address }}
                        </p>
                        <p class="text-gray-500">{{ $order->customer->city }} -
                            {{ $order->customer->country }}
                        </p>
                    </div>
                    <div class="w-full md:w-auto">
                        <h4 class="mb-6 font-bold font-heading">{{ __('Shipping informations') }}</h4>
                        <p class="text-gray-500">
                            {{ $order->customer->email }}
                        </p>
                        <p class="text-gray-500">
                            {{ $order->customer->phone }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap items-center">
                {{-- @dd($order->orderDetails) --}}
                @foreach ($order->orderDetails as $product)
                    <div class="w-full lg:w-2/6 px-4 mb-8 lg:mb-0">
                        <img class="w-full h-32 object-contain" src="{{ asset('images/products/' . $product->image) }}"
                            alt="">
                    </div>
                    <div class="w-full lg:w-4/6 px-4">
                        <div class="flex">
                            <div class="mr-auto">
                                <h3 class="text-xl font-bold font-heading">{{ $product->name }}</h3>
                                <p class="text-gray-500">{!! $product->description !!}</p>
                                <p class="text-gray-500">
                                    <span>{{ __('Quantity') }}:</span>
                                    <span class="text-gray-900 font-bold font-heading">{{ $order->quantity }}</span>
                                </p>
                            </div>
                            <span
                                class="text-2xl font-bold font-heading text-blue-300">{{ format_currency($product->price) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="mb-10">
                <div class="py-3 px-10 rounded-full">
                    <div class="flex justify-between">
                        <span class="font-medium">{{ __('Shipping') }}</span>
                        <span class="font-bold font-heading">
                            {{ format_currency($order->shipping->cost) }}
                        </span>
                    </div>
                </div>
                <div class="py-3 px-10 bg-gray-100 rounded-full">
                    <div class="flex justify-between">
                        <span class="font-medium">{{ __('Tax') }}</span>
                        <span class="font-bold font-heading">
                            {{ format_currency($order->tax_amount) }}
                        </span>
                    </div>
                </div>
                <div class="py-3 px-10 rounded-full">
                    <div class="flex justify-between">
                        <span class="text-base md:text-xl font-bold font-heading">{{ __('Order Total') }}</span>
                        <span class="font-bold font-heading">
                            {{ format_currency($order->total_amount) }}
                        </span>
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
