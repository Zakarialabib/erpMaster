<div>
    <x-modal wire:model.live="editLanguage">
        <x-slot name="title">
            {{ __('Update language') }}
        </x-slot>
        <x-slot name="content">
            <form wire:submit="update">
                
                <!-- Validation Errors -->
                <x-validation-errors class="mb-4" :errors="$errors" />

                <div class="flex flex-wrap justify-center">
                    <div class="lg:w-1/2 sm:w-full px-3">
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" type="text" class="block mt-1 w-full" wire:model.blur="language.name" />
                        <x-input-error :messages="$errors->get('language.name')" for="name" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-3">
                        <x-label for="code" :value="__('Code')" />
                        <x-input id="code" type="text" class="block mt-1 w-full" disabled
                            wire:model.live="language.code" />
                        <x-input-error :messages="$errors->get('language.code')" for="code" class="mt-2" />
                    </div>
                    <div class="w-full my-4 px-3">
                        <x-button type="submit" primary class="w-full">
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
