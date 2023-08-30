<div>
    <x-modal wire:model.live="createCustomer">
        <x-slot name="title">
            {{ __('Create Customer') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />
            <form wire:submit="create">
                <div class="flex flex-wrap">
                    <div class="md:w-1/2 sm:w-full px-3 mb-4 lg:mb-0">
                        <x-label for="name" :value="__('Name')" required />
                        <x-input id="name" class="block mt-1 w-full" required type="text"
                            wire:model.blur="customer.name" />
                        <x-input-error :messages="$errors->get('customer.name')" for="name" class="mt-2" />
                    </div>

                    <div class="md:w-1/2 sm:w-full px-3 mb-4 lg:mb-0">
                        <x-label for="phone" :value="__('Phone')" required />
                        <x-input id="phone" class="block mt-1 w-full" required type="text"
                            wire:model.blur="customer.phone" />
                        <x-input-error :messages="$errors->get('customer.phone')" for="phone" class="mt-2" />
                    </div>

                    <x-accordion title="{{ __('Details') }}">
                        <div class="flex flex-wrap -mx-2 mb-3">
                            <div class="md:w-1/2 sm:w-full px-3">
                                <x-label for="email" :value="__('Email')" />
                                <x-input id="email" class="block mt-1 w-full" type="email"
                                    wire:model.blur="customer.email" />
                                <x-input-error :messages="$errors->get('customer.email')" class="mt-2" />
                            </div>

                            <div class="md:w-1/2 sm:w-full px-3">
                                <x-label for="address" :value="__('Address')" />
                                <x-input id="address" class="block mt-1 w-full" type="text"
                                    wire:model.blur="customer.address" />
                                <x-input-error :messages="$errors->get('customer.address')" class="mt-2" />
                            </div>

                            <div class="md:w-1/2 sm:w-full px-3">
                                <x-label for="city" :value="__('City')" />
                                <x-input id="city" class="block mt-1 w-full" type="text"
                                    wire:model.blur="customer.city" />
                                <x-input-error :messages="$errors->get('customer.city')" class="mt-2" />
                            </div>

                            <div class="md:w-1/2 sm:w-full px-3">
                                <x-label for="tax_number" :value="__('Tax Number')" />
                                <x-input id="tax_number" class="block mt-1 w-full" type="text"
                                    wire:model.blur="customer.tax_number" />
                                <x-input-error :messages="$errors->get('customer.tax_number')" class="mt-2" />
                            </div>
                        </div>
                    </x-accordion>

                    <div class="w-full px-3 my-4">
                        <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                            {{ __('Create') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
