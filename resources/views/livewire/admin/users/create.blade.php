<div>
    <x-modal wire:model="createModal">
        <x-slot name="title">
            {{ __('Create User') }}
        </x-slot>

        <x-slot name="content">
            <x-validation-errors class="mb-4" :errors="$errors" />
            <form wire:submit="create">
                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="name" :value="__('Name')" required />
                        <x-input id="name" class="block mt-1 w-full" type="text" wire:model="name" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="md:w-1/2 sm:w-full px-3">
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
                        <x-label for="warehouse" :value="__('Warehouse')" />
                        <x-select-list multiple
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            required id="warehouse_id" name="warehouse_id" wire:model="warehouse_id"
                            :options="$this->warehouses" />
                        <x-input-error :messages="$errors->get('warehouse_id')" class="mt-2" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="password" :value="__('Password')" />
                        <x-input id="password" name="password" class="block mt-1 w-full" type="password"
                            wire:model="password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" class="block mt-1 w-full" type="email" wire:model="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="w-full my-2 px-3">
                        <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                            {{ __('Create') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
