<div>
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit Currency') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />
            <form wire:submit="update">
                <div class="grid md:grid-cols-2 grid-cols-1 gap-4 px-3">
                    <div>
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" required type="text" wire:model="name" />
                        <x-input-error :messages="$errors->get('name')" for="name" class="mt-2" />

                    </div>
                    <div>
                        <x-label for="code" :value="__('Code')" />
                        <x-input id="code" class="block mt-1 w-full" type="text" wire:model="code" />
                        <x-input-error :messages="$errors->get('code')" for="code" class="mt-2" />

                    </div>
                    <div>
                        <x-label for="symbol" :value="__('Symbol')" />
                        <x-input id="symbol" class="block mt-1 w-full" type="text" wire:model="symbol" />
                        <x-input-error :messages="$errors->get('symbol')" for="symbol" class="mt-2" />

                    </div>
                    <div>
                        <x-label for="exchange_rate" :value="__('Rate')" />
                        <x-input id="exchange_rate" class="block mt-1 w-full" type="text"
                            wire:model="exchange_rate" />
                        <x-input-error :messages="$errors->get('exchange_rate')" for="exchange_rate" class="mt-2" />

                    </div>
                </div>

                <div class="w-full py-2 px-3">
                    <x-button primary type="submit" class="w-full text-center" wire:click="update"
                        wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
