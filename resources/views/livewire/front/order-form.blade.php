<div>
    <form wire:submit="save" class="container mx-auto py-4">
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-4 items-center border border-dashed border-gray-100">
            <div>
                <label class="font-bold font-heading text-gray-600" for="">{{ __('FullName') }}</label>
                <input wire:model="name"
                    class="block w-full mt-4 py-2 px-4 bg-white border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md"
                    type="text">
            </div>
            <div>
                <label class="font-bold font-heading text-gray-600" for="">{{ __('Phone') }}</label>
                <input wire:model="phone"
                    class="block w-full mt-4 py-2 px-4 bg-white border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md"
                    type="text">
            </div>
            <div class="col-span-full">
                <label class="font-bold font-heading text-gray-600" for="">{{ __('Address') }}</label>
                <input wire:model="address"
                    class="block w-full mt-4 py-2 px-4 bg-white border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md"
                    type="text">
            </div>
            <div class="col-span-full flex py-2 justify-center">
                <button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                    class="block text-center text-white font-bold font-heading py-2 px-4 rounded-md uppercase bg-green-400 hover:bg-green-200 transition cursor-pointer">
                    {{ __('Order Now') }}
                </button>
            </div>
        </div>
    </form>
</div>
