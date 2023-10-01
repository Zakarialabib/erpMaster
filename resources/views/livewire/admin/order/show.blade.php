<div>
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Show Order') }}
        </x-slot>

        <x-slot name="content">
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Date') }}</div>
                <div>{{ $order->date }}</div>
            </div>
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Reference') }}</div>
                <div>{{ $order->reference }}</div>
            </div>
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Shipping') }}</div>
                <div>{{ $order->shipping->title }}</div>
            </div>

            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Customer Name') }}</div>
                <div>{{ $order->customer->name }}</div>
            </div>

            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Tax Amount') }}</div>
                <div>{{ $order->tax_amount }}</div>
            </div>
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Discount Amount') }}</div>
                <div>{{ $order->discount_amount }}</div>
            </div>
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Shipping Amount') }}</div>
                <div>{{ $order->shipping_amount }}</div>
            </div>
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Total Amount') }}</div>
                <div>{{ $order->total_amount }}</div>
            </div>
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Payment Date') }}</div>
                <div>{{ $order->payment_date }}</div>
            </div>
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Payment Method') }}</div>
                <div>{{ $order->payment_method }}</div>
            </div>
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Payment Status') }}</div>
                <div>{{ $order->payment_status->label }}</div>
            </div>
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Shipping Status') }}</div>
                <div>{{ $order->shipping_status->label }}</div>
            </div>
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Status') }}</div>
                <div>{{ $order->status->label }}</div>
            </div>
            <div class="w-full flex flex-row items-center gap-4">
                <div class="font-bold">{{ __('Note') }}</div>
                <div>{{ $order->note }}</div>
            </div>
        </x-slot>
    </x-modal>
</div>
