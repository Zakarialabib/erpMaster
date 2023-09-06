<div>
    <!-- Create Modal -->
    <x-modal wire:model="createModal">
        <x-slot name="title">
            {{ __('Create Shipping') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />

            <form wire:submit="create">
                <div class="flex flex-wrap space-y-2">
                    <div class="xl:w-1/2 md:w-full px-2">
                        <x-label for="title" :value="__('Title')" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title"
                            wire:model="title" />
                        <x-input-error :messages="$errors->get('title')" for="title" class="mt-2" />
                    </div>
                    <div class="xl:w-1/2 md:w-full px-2">
                        <x-label for="subtitle" :value="__('Subtitle')" />
                        <x-input id="subtitle" class="block mt-1 w-full" type="text" name="subtitle"
                            wire:model="subtitle" />
                        <x-input-error :messages="$errors->get('subtitle')" for="subtitle" class="mt-2" />
                    </div>

                    <div class="xl:w-1/2 md:w-full px-2">
                        <x-label for="cost" :value="__('Cost')" />
                        <x-input id="cost" class="block mt-1 w-full" type="number" name="cost"
                            wire:model="cost" />
                        <x-input-error :messages="$errors->get('cost')" for="cost" class="mt-2" />
                    </div>

                    <div class="xl:w-1/2 md:w-full px-2">
                        <x-label for="is_pickup" :value="__('Is Pickup')" />
                        <x-input id="is_pickup" class="block mt-1 w-full" type="checkbox" name="is_pickup"
                            wire:model="is_pickup" />
                        <x-input-error :messages="$errors->get('is_pickup')" for="is_pickup" class="mt-2" />
                    </div>

                    <div class="w-full px-3">
                        <x-button primary type="submit" wire:loading.attr="disabled" class="w-full">
                            {{ __('Create') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
    <!-- End Create Modal -->
</div>
