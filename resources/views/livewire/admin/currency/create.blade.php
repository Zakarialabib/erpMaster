<div>
    <x-modal wire:model="createModal">
        <x-slot name="title">
            {{ __('Create Currency') }}
        </x-slot>

        <x-slot name="content">

            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />

            <form wire:submit="create">
                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="name" :value="__('Name')" required />
                        <x-input id="name" class="block mt-1 w-full" required type="text"
                            wire:model="name" />
                        <x-input-error :messages="$errors->get('name')" for="name" class="mt-2" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="code" :value="__('Code')" required />
                        <x-input id="code" class="block mt-1 w-full" type="text"
                            wire:model="code" />
                        <x-input-error :messages="$errors->get('code')" for="code" class="mt-2" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="symbol" :value="__('Symbol')" required />
                        <x-input id="symbol" class="block mt-1 w-full" type="text"
                            wire:model="symbol" />
                        <x-input-error :messages="$errors->get('symbol')" for="name" class="mt-2" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="exchange_rate" :value="__('Exchange Rate')" required />
                        <x-input id="exchange_rate" class="block mt-1 w-full" type="text"
                            wire:model="exchange_rate" />
                        <x-input-error :messages="$errors->get('exchange_rate')" for="name" class="mt-2" />
                    </div>
                </div>
                <div class="w-full px-3">
                    <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
