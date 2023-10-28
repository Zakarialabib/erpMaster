<div>

    <div class="fixed inset-0 overflow-hidden z-50" style="display:none" x-on:click.away="showCart = false"
        x-show="showCart" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-4" x-close-on-escape="true" x-cloak>
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                x-on:click="showCart = false"></div>
            <div class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                <div class="w-screen max-w-sm">
                    <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                        <div class="py-6 overflow-y-auto px-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium text-gray-900">{{ __('Cart') }}</h2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button x-on:click="showCart = false"
                                        class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <span class="sr-only">{{ __('Close panel') }}</span>
                                        <svg class="h-6 w-6" x-description="Heroicon name: outline/x"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 border-t border-gray-200 py-6 px-4 sm:px-6">
                            <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-6 items-center">
                                @forelse ($this->cartItems as $item)
                                    <div class="w-auto flex flex-col mb-10 border-2 border-green-300 shadow-sm text-sm">
                                        <div class="relative flex items-center justify-center bg-gray-100">
                                            @if (!empty($item->rowId))
                                                <div
                                                    class="absolute top-0 right-0 bg-white p-1 text-center">
                                                    <button wire:click="removeFromCart('{{ $item->rowId }}')"
                                                        class="text-red-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            @endif
                                            @if (!empty($item->model->image))
                                                <img class="bg-cover"
                                                    src="{{ asset('images/products') }}/{{ $item->model->image }}"
                                                    alt="{{ $item->name }}">
                                            @endif
                                            <div
                                                class="absolute bottom-0 text-lg font-bold font-heading bg-white bg-opacity-80 w-full text-gray-900 text-center">
                                                @if (!empty($item->name))
                                                    {{ $item->name }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-2 mb-3 mt-5 justify-center">
                                            @if (!empty($item->price))
                                                <p class="text-sm text-green-600 font-bold font-heading">
                                                    {{ format_currency($item->price) }}
                                                </p>
                                            @endif
                                            @if (!empty($item->rowId))
                                                <button wire:click="decreaseQuantity('{{ $item->rowId }}')"
                                                    class="text-gray-600 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                                                    <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M4 10a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z"
                                                            clip-rule="evenodd">
                                                        </path>
                                                    </svg>
                                                </button>
                                            @endif
                                            @if (!empty($item->qty))
                                                <span class="text-gray-700 mx-2">{{ $item->qty }}</span>
                                            @endif
                                            @if (!empty($item->rowId))
                                                <button wire:click="increaseQuantity('{{ $item->rowId }}')"
                                                    class="text-gray-600 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                                                    <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 5a1 1 0 011 1v4h4a1 1 0 110 2h-4v4a1 1 0 11-2 0v-4H5a1 1 0 110-2h4V6a1 1 0 011-1z"
                                                            clip-rule="evenodd">
                                                        </path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex flex-wrap mb-10">
                                        <h2 class="mb-6 text-4xl font-bold font-heading text-white">
                                            {{ __('Cart Empty') }}</h2>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="p-6 md:p-12 bg-gray-900">
                            <div class="flex mb-8 items-center justify-between pb-5 border-b border-blue-100">
                                <span class="text-blue-50">{{ __('Cart total') }}</span>
                                <span class="text-lg font-bold font-heading text-white">
                                    {{ format_currency($this->cartTotal) }}
                                </span>
                            </div>
                            <a class="block w-full py-4 bg-red-600 hover:bg-red-800 text-center text-white font-bold font-heading uppercase rounded-md transition duration-200 shadow-md"
                                href="{{ route('front.checkout') }}">{{ __('Go to Checkout') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
