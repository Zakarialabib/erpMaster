<div>
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="update">
                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-3 mb-6">
                        <x-label for="name" :value="__('Name')" required />
                        <x-input id="name" class="block mt-1 w-full" type="text" wire:model="name" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="w-full sm:w-1/2 px-3 mb-6">
                        <x-label for="phone" :value="__('Phone')" required />
                        <x-input id="phone" class="block mt-1 w-full" required type="text" wire:model="phone" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="md:w-1/2 sm:w-full px-3">
                        <label for="role">{{ __('Role') }} <span class="text-red-500">*</span></label>
                        <x-select-list
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            required id="role" name="role" wire:model.live="role" :options="$this->roles" />
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <label for="role">{{ __('Customer Group') }} <span class="text-red-500">*</span></label>
                        <x-select-list
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            required id="customer_group_id" name="customer_group_id" wire:model.live="customer_group_id"
                            :options="$this->customerGroups" />
                        <x-input-error :messages="$errors->get('customer_group_id')" class="mt-2" />
                    </div>
                    <x-accordion title="{{ __('Details') }}">
                        <div class="flex flex-wrap">


                            <div class="w-full sm:w-1/2 px-3 mb-6">
                                <x-label for="email" :value="__('Email')" />
                                <x-input id="email" class="block mt-1 w-full" type="email" wire:model="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="w-full sm:w-1/2 px-3 mb-6">
                                <x-label for="address" :value="__('Address')" />
                                <x-input id="address" class="block mt-1 w-full" type="text" wire:model="address" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div class="w-full sm:w-1/2 px-3 mb-6">
                                <x-label for="city" :value="__('City')" />
                                <x-input id="city" class="block mt-1 w-full" type="text" wire:model="city" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <div class="w-full sm:w-1/2 px-3 mb-6">
                                <x-label for="tax_number" :value="__('Tax Number')" />
                                <x-input id="tax_number" class="block mt-1 w-full" type="text"
                                    wire:model="tax_number" />
                                <x-input-error :messages="$errors->get('tax_number')" for="" class="mt-2" />
                            </div>
                        </div>
                    </x-accordion>

                    <div class="w-full px-3">
                        <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
