<div>
    @section('title', __('Create Purchase'))

    <x-theme.breadcrumb :title="__('Create Purchase')" :parent="route('admin.purchases.index')" :parentName="__('Purchases List')" :children="URL::Current()" :childrenName="__('Create Purchase')">
        <x-button primary
            wire:click="dispatchTo('admin.suppliers.create', 'createModal')">>{{ __('Create Supplier') }}</x-button>

    </x-theme.breadcrumb>
    <div class="flex flex-wrap">

        <div class="lg:w-1/2 sm:w-full h-full">
            <livewire:search-product />
        </div>

        <div class="lg:w-1/2 sm:w-full h-full">
            <x-validation-errors class="mb-4" :errors="$errors" />

            <form wire:submit="store">
                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <x-label for='supplier_id' :value="__('Supplier')" required />
                        <x-select-list
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            required id="supplier_id" name="supplier_id" wire:model.live="supplier_id"
                            :options="$this->suppliers" />
                        <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <x-label for="date" :value="__('Date')" required />
                        <input type="date" name="date" required wire:model="date"
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1">
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <x-label for="warehouse" :value="__('Warehouse')" />
                        <x-select-list
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            required id="warehouse_id" name="warehouse_id" wire:model.live="warehouse_id"
                            :options="$this->warehouses" />
                        <x-input-error :messages="$errors->get('warehouse_id')" class="mt-2" />
                    </div>
                </div>

                <livewire:product-cart :cartInstance="'purchase'" />

                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="w-full md:w-1/3 px-2 mb-2">
                        <x-label for="status" :value="__('Status')" required />
                        <select
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            name="status" id="status" wire:model.live="status" required>
                            <option>{{ __('Select Status') }}</option>  
                            @foreach (App\Enums\PurchaseStatus::values() as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                    <div class="w-full md:w-1/3 px-2 mb-2">
                        <x-label for="payment_method" :value="__('Payment Method')" required />
                        <select
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            wire:model.live="payment_method" name="payment_method" id="payment_method" required>
                            <option>{{ __('Select Payment Method') }}</option>
                            <option value="Cash">{{ __('Cash') }}</option>
                            <option value="Bank Transfer">{{ __('Bank Transfer') }}</option>
                            <option value="Cheque">{{ __('Cheque') }}</option>
                            <option value="Other">{{ __('Other') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                    </div>
                    <div class="w-full md:w-1/3 px-2 mb-2">
                        <x-label for="paid_amount" :value="__('Amount Paid')" required />
                        <x-input id="paid_amount" type="text" wire:model="paid_amount" name="paid_amount" required />
                        <x-input-error :messages="$errors->get('paid_amount')" class="mt-2" />
                    </div>
                </div>

                <div class="mb-4">
                    <label for="note">{{ __('Note (If Needed)') }}</label>
                    <textarea name="note" id="note" rows="5" wire:model="note"
                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"></textarea>
                    <x-input-error :messages="$errors->get('note')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-button danger type="button" wire:click="resetCart" wire:loading.attr="disabled"
                        class="ml-2 font-bold">
                        {{ __('Reset') }}
                    </x-button>

                    <button
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150 bg-green-500 hover:bg-green-700"
                        type="submit" wire:click="proceed" wire:loading.attr="disabled"
                        {{ $total_amount == 0 ? 'disabled' : '' }}>
                        {{ __('Proceed') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <livewire:admin.suppliers.create />
</div>
