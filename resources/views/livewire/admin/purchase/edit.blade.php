<div>
    @section('title', __('Edit Purchase'))

    <x-theme.breadcrumb :title="__('Edit Purchase')" :parent="route('admin.purchases.index')" :parentName="__('Purchases List')" :children="URL::Current()" :childrenName="__('Edit Purchase')">

    </x-theme.breadcrumb>

    <div class="flex flex-wrap">

        <div class="lg:w-1/2 sm:w-full h-full">
            <livewire:search-product :$warehouse_id="$this->adjustment->warehouse_id" lazy />
        </div>

        <div class="lg:w-1/2 sm:w-full h-full">
            <x-validation-errors class="mb-4" :errors="$errors" />

            <form wire:submit="update">
                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <label for="reference">{{ __('Reference') }} <span class="text-red-500">*</span></label>
                        <x-input type="text" wire:model.live="reference" name="reference" required readonly />
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <label for="supplier_id">{{ __('Supplier') }} <span class="text-red-500">*</span></label>
                        <x-select-list :options="$this->supplier" name="supplier_id" id="supplier_id" wire:model.live="supplier_id" />
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <x-label for="warehouse" :value="__('Warehouse')" />
                        <x-select-list disabled
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            required id="warehouse_id" name="warehouse_id" wire:model.live="warehouse_id"
                            :options="$this->warehouses" />
                        <x-input-error :messages="$errors->get('warehouse_id')" class="mt-2" />
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <x-label for="date" :value="__('Date')" required />
                        <input type="date" name="date" required wire:model.live="date"
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1">
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>

                </div>

                <livewire:product-cart :cartInstance="'purchase'" :data="$purchase" lazy />

                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                        <label for="status">{{ __('Status') }} <span class="text-red-500">*</span></label>
                        <select
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            name="status" id="status" required wire:model.live="status">
                            @foreach (\App\Enums\PurchaseStatus::cases() as $status)
                                <option {{ $status == $status ? 'selected' : '' }}
                                    value="{{ $status->value }}">
                                    {{ __($status->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                        <label for="payment_method">{{ __('Payment Method') }} <span
                                class="text-red-500">*</span></label>
                        <input type="text" wire:model.live="payment_method"
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            name="payment_method" required readonly>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                        <label for="paid_amount">{{ __('Amount Received') }} <span class="text-red-500">*</span></label>
                        <input id="paid_amount" type="text" wire:model.live="paid_amount"
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            name="paid_amount" required readonly>
                    </div>
                </div>

                <div class="w-full px-3 mb-4">
                    <label for="note">{{ __('Note') }}</label>
                    <textarea name="note" id="note" rows="5" wire:model.live="note"
                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1">{{ $purchase->note }}</textarea>
                </div>

                <div class="w-full px-3">
                    <x-button type="submit" primary class="w-full text-center">
                        {{ __('Update Purchase') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
