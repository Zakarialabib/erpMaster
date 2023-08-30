<div>
    <x-modal wire:model.live="paymentModal">
        <x-slot name="title">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Purchase Payment') }}
            </h2>
        </x-slot>
        <x-slot name="content">
            <x-validation-errors class="mb-4" :errors="$errors" />
            <form wire:submit="paymentSave">
                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                        <x-label for="date" :value="__('Date')" required />
                        <input type="date" wire:model.blur="date" id="date" class="block w-full mt-1" required>
                        <x-input-error :messages="$errors->first('date')" />
                    </div>
                    <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                        <x-label for="amount" :value="__('Amount')" required />
                        <x-input type="text" wire:model.blur="amount" id="amount" class="block w-full mt-1"
                            required />
                        <x-input-error :messages="$errors->first('amount')" />
                    </div>
                    <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                        <x-label for="payment_method" :value="__('Payment Method')" required />
                        <select wire:model.live="payment_method"
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            name="payment_method" id="payment_method" required>
                            <option value="Cash">{{ __('Cash') }}</option>
                            <option value="Bank Transfer">{{ __('Bank Transfer') }}</option>
                            <option value="Cheque">{{ __('Cheque') }}</option>
                            <option value="Other">{{ __('Other') }}</option>
                        </select>
                        <x-input-error :messages="$errors->first('payment_method')" />
                    </div>
                </div>

                <div class="mb-4  px-3">
                    <x-label for="note" :value="__('Note')" />
                    <textarea wire:model.blur="note"
                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                        rows="2" name="note">{{ old('note') }}</textarea>
                </div>

                <div class="w-full flex justfiy-center px-3">
                    <x-button primary type="submit" wire:loading.attr="disabled">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
