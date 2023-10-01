<div>
    <x-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Delivery Details') }}
        </x-slot>

        <x-slot name="content">
            <div class="w-full">
                <div class="flex flex-wrap">
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="reference" :value="__('Reference')" />
                        {{ $this->delivery?->reference }}
                    </div>
                    @if ($this->delivery?->sale_id)
                        <div class="lg:w-1/2 sm:w-full px-2">
                            <x-label for="sale_id" :value="__('Sale infos')" />
                            {{ $this->delivery?->sale->reference }}
                        </div>
                    @endif
                    @if ($this->delivery?->order_id)
                        <div class="lg:w-1/2 sm:w-full px-2">
                            <x-label for="order_id" :value="__('Order ID')" />
                            {{ $this->delivery?->order_id }}
                        </div>
                    @endif
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="user_id" :value="__('User ID')" />
                        {{ $this->delivery?->user->name }}
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="address" :value="__('Address')" />
                        {{ $this->delivery?->address }}
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="shipping_id" :value="__('Shipping ID')" />
                        {{ $this->delivery?->shipping->title }}
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="delivered_by" :value="__('Delivered By')" />
                        {{ $this->delivery?->delivered_by }}
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="recieved_by" :value="__('Received By')" />
                        {{ $this->delivery?->recieved_by }}
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="document" :value="__('Document')" />
                        {{ $this->delivery?->document }}
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="status" :value="__('Status')" />
                        {{ $this->delivery?->status }}
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="note" :value="__('Note')" />
                        {{ $this->delivery?->note }}
                    </div>
                </div>
            </div>
        </x-slot>
    </x-modal>
</div>
