<div>
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit Expense') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="update">
                <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-4 px-3 mb-3">
                    <div>
                        <x-label for="reference" :value="__('Reference')" />
                        <x-input wire:model="reference" id="reference" type="text" required />
                        <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                    </div>
                    @if ($sale_id)
                        <div>
                            <x-label for="sale_id" :value="__('Sale')" required />
                            <select wire:model="sale_id" id="sale_id" class="block mt-1 w-full" required>
                                <option value="">{{ __('Select Sale') }}</option>
                                @foreach ($this->sales as $sale)
                                    <option value="{{ $sale->id }}"
                                        @if ($sale_id == $sale->id) selected @endif>
                                        {{ $sale->id }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('sale_id')" class="mt-2" />
                        </div>
                    @elseif ($order_id)
                        <div>
                            <x-label for="order_id" :value="__('Order ID')" required />
                            <select wire:model="order_id" id="order_id" class="block mt-1 w-full" required>
                                <option value="">{{ __('Select Order ID') }}</option>
                                @foreach ($this->orders as $order)
                                    <option value="{{ $order->id }}"
                                        @if ($order_id == $order->id) selected @endif>
                                        {{ $order->id }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('order_id')" class="mt-2" />
                        </div>
                    @endif
                    <div>
                        <x-label for="shipping_id" :value="__('Shipping')" required />
                        <select wire:model="shipping_id" id="shipping_id" class="block mt-1 w-full" required>
                            <option value="">{{ __('Select Shipping ID') }}</option>
                            @foreach ($this->shippings as $shipping)
                                <option value="{{ $shipping->id }}" @if ($shipping_id == $shipping->id) selected @endif>
                                    {{ $shipping->title }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('shipping_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="document" :value="__('Document')" />
                        <x-input wire:model="document" id="document" class="block mt-1 w-full" type="text" />
                        <x-input-error :messages="$errors->get('document')" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="note" :value="__('Note')" />
                        <x-input wire:model="note" id="note" class="block mt-1 w-full" type="text" />
                        <x-input-error :messages="$errors->get('note')" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="address" :value="__('Address')" />
                        <x-input wire:model="address" id="address" class="block mt-1 w-full" type="text" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="delivered_by" :value="__('Delivered By')" />
                        <x-input wire:model="delivered_by" id="delivered_by" class="block mt-1 w-full" type="text" />
                        <x-input-error :messages="$errors->get('delivered_by')" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="recieved_by" :value="__('Recieved By')" />
                        <x-input wire:model="recieved_by" id="recieved_by" class="block mt-1 w-full" type="text" />
                        <x-input-error :messages="$errors->get('recieved_by')" class="mt-2" />
                    </div>
                </div>
                <div class="w-full px-3">
                    <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
