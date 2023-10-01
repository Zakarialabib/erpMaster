<div>
    @section('title', __('Checkout'))

    <div class="mx-auto px-3 sm:px-6 lg:px-8 py-12 text-center">
        <span class="text-xl text-gray-300 uppercase font-bold mb-4 block tracking-[0.15em]">
            {{ __('Complete your order') }}
        </span>
        <h2
            class="text-first-brand font-extrabold text-[25px] leading-[35px] sm:text-[30px] sm:leading-[40px] md:text-[36px] md:leading-[46px] lg:text-header-2 mx-auto capitalize relative">
            {{ __('Checkout') }}
        </h2>
    </div>

    <div class="flex flex-wrap mb-10">
        <div class="w-full lg:w-1/2 px-4">
            <form wire:submit="checkout">
                @if (auth()->guard('customer')->check())
                    <div class="flex my-5 items-center">
                        <span
                            class="inline-flex mr-8 items-center justify-center w-12 h-12 rounded-full bg-blue-300 text-white">1</span>
                        <h3 class="text-2xl font-bold font-heading">
                            {{ __('Already have an account ?') }}
                        </h3>
                    </div>
                    <div class="flex my-5 items-center">
                        <div class="w-full px-2">
                            <label class="font-bold font-heading text-gray-600"
                                for="">{{ __('E-mail address') }}</label>
                            <input wire:model="email" disabled
                                class="block w-full mt-4 py-2 px-4 bg-white border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md"
                                type="email">
                            <x-input-error :messages="$errors->get('email')" for="email" class="mt-2" />
                        </div>
                    </div>
                @else
                    <div class="flex my-5 items-center">
                        <span
                            class="inline-flex mr-8 items-center justify-center w-12 h-12 rounded-full bg-blue-300 text-white">1</span>
                        <h3 class="text-2xl font-bold font-heading">
                            {{ __('Fill billing informations') }}
                        </h3>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full px-2 md:w-1/2">
                            <label class="font-bold font-heading text-gray-600"
                                for="">{{ __('E-mail address') }}</label>
                            <input wire:model="email"
                                class="block w-full mt-4 py-2 px-4 bg-white border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md"
                                type="email">
                            <x-input-error :messages="$errors->get('email')" for="email" class="mt-2" />
                        </div>
                        <div class="w-full px-2 md:w-1/2">
                            <label class="font-bold font-heading text-gray-600"
                                for="">{{ __('Password') }}</label>
                            <input wire:model="password"
                                class="block w-full mt-4 py-2 px-4 bg-white border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md"
                                type="password">
                            <x-input-error :messages="$errors->get('password')" for="password" class="mt-2" />
                        </div>
                    </div>
                @endif

                <div class="flex my-5 items-center">
                    <span
                        class="inline-flex mr-8 items-center justify-center w-12 h-12 rounded-full bg-green-500 text-white">2</span>
                    <h3 class="text-2xl font-bold font-heading">{{ __('Shipping informations') }}</h3>
                </div>
                <div class="flex mb-5 items-center">
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/2 px-4">
                            
                            <label class="font-bold font-heading text-gray-600"
                                for="name">{{ __('Full name') }}</label>
                            <input wire:model="name" id="name"
                                class="block w-full mt-4 py-2 px-4 bg-white border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md"
                                type="text">
                            <x-input-error :messages="$errors->get('name')" for="name" class="mt-2" />
                        </div>
                        <div class="w-full md:w-1/2 px-4">
                            <label class="font-bold font-heading text-gray-600"
                                for="phone">{{ __('Phone') }}</label>
                            <input wire:model="phone" id="phone"
                                class="block w-full mt-4 py-2 px-4 bg-white border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md"
                                type="text">
                            <x-input-error :messages="$errors->get('phone')" for="phone" class="mt-2" />
                        </div>
                        <div class="w-full md:w-1/2 px-4">
                            <label class="font-bold font-heading text-gray-600"
                                for="address">{{ __('Address') }}</label>
                            <input wire:model="address" id="address"
                                class="block w-full mt-4 py-2 px-4 bg-white border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md"
                                type="text">
                            <x-input-error :messages="$errors->get('address')" for="address" class="mt-2" />
                        </div>

                        <div class="w-full md:w-1/2 px-4">
                            <label class="font-bold font-heading text-gray-600"
                                for="">{{ __('Country') }}</label>
                            <input wire:model="country" disabled
                                class="block w-full mt-4 py-2 px-4 bg-white border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md"
                                type="text">
                            <x-input-error :messages="$errors->get('country')" for="country" class="mt-2" />
                        </div>
                        <div class="w-full md:w-1/2 px-4">
                            <label class="font-bold font-heading text-gray-600"
                                for="city">{{ __('City') }}</label>
                            <input wire:model="city" id="city"
                                class="block w-full mt-4 py-2 px-4 bg-white border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md"
                                type="text">
                            <x-input-error :messages="$errors->get('city')" for="city" class="mt-2" />
                        </div>
                        <div class="mb-5 w-full md:w-1/2 px-4">

                            <label class="font-bold font-heading text-gray-600">
                                {{ __('Shipping methods') }}
                            </label>
                            <select
                                class="block mt-4 bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                                id="shipping_id" name="shipping_id" wire:model.live="shipping_id"
                                wire:change="updateCartTotal">
                                <option value="">{{ __('Choose Shipping Method') }}</option>
                                @foreach ($this->shippings as $shipping)
                                    <option value="{{ $shipping->id }}">{{ $shipping->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-4">
                            <label class="font-bold font-heading text-gray-600"
                                for="">{{ __('Payment method') }}</label>
                            <div class="flex flex-wrap -mx-4 mb-5">
                                <label class="flex px-4 w-full sm:w-auto items-center" for="">
                                    <input type="radio" name="payment_method" value="cash"
                                        wire:model="payment_method" checked>
                                    <span class="ml-5 text-sm">{{ __('Cash on Delivery') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="w-full lg:w-1/2">
            <div class="py-16 px-6 md:px-14 bg-white">
                <h2 class="text-4xl mb-10 text-center font-bold font-heading">{{ __('Order summary') }}</h2>
                <div class="mb-5 border-b grid lg:grid-cols-2 md:grid-cols-3 sm:grid-cols-2 gap-6 items-center">
                    @foreach ($this->cartItems as $item)
                        <div class="w-full flex flex-col mb-10 border-2 border-green-300 shadow-sm">
                            <div class="relative flex items-center justify-center bg-gray-100">
                                @if (!empty($item->rowId))
                                    <div class="absolute top-0 right-0 bg-white p-1 text-center">
                                        <button wire:click="removeFromCart('{{ $item->rowId }}')"
                                            class="text-red-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                @endif
                                @if (!empty($item->model->image))
                                    <img class="w-full bg-cover"
                                        src="{{ asset('images/products') }}/{{ $item->model->image }}"
                                        alt="{{ $item->name }}">
                                @endif
                                <div
                                    class="absolute bottom-0 text-xl font-bold font-heading bg-white bg-opacity-80 w-full text-gray-900 text-center">
                                    @if (!empty($item->name))
                                        {{ $item->name }}
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col items-center mt-5 justify-center h-full">
                                <div class="flex items-center space-x-2 mb-3">
                                    @if (!empty($item->price))
                                        <p class="text-md text-green-600 font-bold font-heading">
                                            {{ format_currency($item->price) }}
                                        </p>
                                    @endif
                                    @if (!empty($item->rowId))
                                        <button wire:click="decreaseQuantity('{{ $item->rowId }}')"
                                            class="text-gray-600 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
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
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 5a1 1 0 011 1v4h4a1 1 0 110 2h-4v4a1 1 0 11-2 0v-4H5a1 1 0 110-2h4V6a1 1 0 011-1z"
                                                    clip-rule="evenodd">
                                                </path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-5">
                    <div class="py-3 px-10 bg-blue-50 rounded-full">
                        <div class="flex justify-between">
                            <span class="font-medium">{{ __('Subtotal') }}</span>
                            <span class="font-bold font-heading">
                                {{ format_currency($this->subTotal) }}
                            </span>
                        </div>
                    </div>
                    <div class="py-3 px-10 rounded-full">
                        <div class="flex justify-between">
                            <span class="font-medium">{{ __('Shipping') }}</span>
                            @if (!empty($this->shipping))
                                <span class="font-bold font-heading">
                                    {{ format_currency($this->shipping->cost) }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="py-3 px-10 rounded-full">
                        <div class="flex justify-between">
                            <span class="text-base md:text-xl font-bold font-heading">{{ __('Total') }}</span>
                            @if (!empty($this->cartTotal))
                                <span class="font-bold font-heading">
                                    {{ format_currency($this->cartTotal) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <button
                    class="block w-full py-4 bg-green-500 hover:bg-green-700 text-center text-white font-bold font-heading uppercase rounded-md transition duration-200"
                    type="button" wire:click="checkout" wire:loading.attr="disabled"
                    wire:loading.class="opacity-50" wire:target="checkout">
                    {{ __('Confirm Order') }}
                </button>
            </div>
        </div>
    </div>
</div>
