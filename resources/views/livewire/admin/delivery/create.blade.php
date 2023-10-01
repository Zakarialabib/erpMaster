<div>
    <x-modal wire:model="createModal">
        <x-slot name="title">
            {{ __('Create Delivery') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />

            <form wire:submit="create">
                <div class="flex flex-wrap mb-3">
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="reference" :value="__('Reference')" required />
                        <x-input wire:model="reference" id="reference" class="block mt-1 w-full" type="text" required />
                        <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                    </div>

                    @if ($sale_id)
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-label for="sale_id" :value="__('Sale')" required />
                            <select wire:model="sale_id" id="sale_id" class="block mt-1 w-full">
                                <option value="">{{ __('Select Sale') }}</option>
                                @foreach ($this->sales as $sale)
                                    <option value="{{ $sale->id }}">{{ $sale->id }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('sale_id')" class="mt-2" />
                        </div>
                    @elseif ($order_id)
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <x-label for="order_id" :value="__('Order')" required />
                            <select wire:model="order_id" id="order_id" class="block mt-1 w-full">
                                <option value="">{{ __('Select Order ID') }}</option>
                                @foreach ($this->orders as $order)
                                    <option value="{{ $order->id }}">
                                        {{ $order->id }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('order_id')" class="mt-2" />
                        </div>
                    @endif

                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <x-label for="shipping_id" :value="__('Shipping')" required />
                        <select wire:model="shipping_id" id="shipping_id" class="block mt-1 w-full" required>
                            <option value="">{{ __('Select Shipping ID') }}</option>
                            @foreach ($this->shippings as $shipping)
                                <option value="{{ $shipping->id }}">
                                    {{ $shipping->title }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('shipping_id')" class="mt-2" />
                    </div>

                    <x-accordion title="details">
                        <div class="flex flex-wrap mb-3">

                            <div class="md:w-1/2 sm:w-full px-3">
                                <x-label for="document" :value="__('Document')" />
                                <x-input wire:model="document" id="document" class="block mt-1 w-full"
                                    type="text" />
                                <x-input-error :messages="$errors->get('document')" class="mt-2" />
                            </div>

                            <div class="md:w-1/2 sm:w-full px-3">
                                <x-label for="note" :value="__('Note')" />
                                <x-input wire:model="note" id="note" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('note')" class="mt-2" />
                            </div>

                            <div class="md:w-1/2 sm:w-full px-3">
                                <x-label for="address" :value="__('Address')" />
                                <x-input wire:model="address" id="address" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div class="md:w-1/2 sm:w-full px-3">
                                <x-label for="delivered_by" :value="__('Delivered By')" />
                                <x-input wire:model="delivered_by" id="delivered_by" class="block mt-1 w-full"
                                    type="text" />
                                <x-input-error :messages="$errors->get('delivered_by')" class="mt-2" />
                            </div>

                            <div class="md:w-1/2 sm:w-full px-3">
                                <x-label for="recieved_by" :value="__('Recieved By')" />
                                <x-input wire:model="recieved_by" id="recieved_by" class="block mt-1 w-full"
                                    type="text" />
                                <x-input-error :messages="$errors->get('recieved_by')" class="mt-2" />
                            </div>
                        </div>
                    </x-accordion>
                </div>

                <div class="w-full pb-2 px-3">
                    <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
