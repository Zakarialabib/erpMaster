<div>
    <form wire:submit="save" class="container mx-auto py-4">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-4 items-center border border-dashed border-gray-100">
            <div>
                <label class="font-bold font-heading text-gray-600" for="">{{ __('FullName') }}</label>
                <x-input wire:model="name" required type="text" />
            </div>
            <div>
                <label class="font-bold font-heading text-gray-600" for="">{{ __('Phone') }}</label>
                <x-input wire:model="phone" required type="text" />
            </div>
            <div class="col-span-full">
                <label class="font-bold font-heading text-gray-600" for="">{{ __('Address') }}</label>
                <x-input wire:model="address" type="text" id="address" />
            </div>
            <div class="col-span-full flex py-2 justify-center">
                <x-button type="button" wire:click="save" wire:loading.attr="disabled" wire:target="save"
                    successOutline>
                    {{ __('Order Now') }}
                </x-button>
            </div>
        </div>
    </form>
</div>
