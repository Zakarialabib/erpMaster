<div>
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit Order') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="update">
                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                        <x-label for="reference" :value="__('Reference')" />
                        <x-input wire:model="reference" id="reference" type="text" required />
                        <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                    </div>
                    <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                        <x-label for="date" :value="__('Date')" />
                        <x-input-date wire:model="date" id="date" name="date" required />
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>

                    <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                        <x-label for="shippnig_id" :value="__('Shipping')" />
                        <select required
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            id="shippnig_id" name="shippnig_id" wire:model.live="shippnig_id">
                            @foreach ($this->shippings as $shipping)
                                <option value="{{ $shipping->id }}">
                                    {{ $shipping->title }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('shippnig_id')" class="mt-2" />
                    </div>
                 
                </div>
                <div class="w-full px-3">
                    <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
