<div>
    <!-- Create Modal -->
    <x-modal wire:model="createModal">
        <x-slot name="title">
            {{ __('Create Slider') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />

            <form wire:submit="create">
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <x-label for="title" :value="__('Title')" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" wire:model="title" />
                        <x-input-error :messages="$errors->get('title')" for="title" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="subtitle" :value="__('Subtitle')" />
                        <x-input id="subtitle" class="block mt-1 w-full" type="text" name="subtitle"
                            wire:model="subtitle" />
                        <x-input-error :messages="$errors->get('subtitle')" for="subtitle" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="bg_color" :value="__('Background Color')" />
                        <x-input id="bg_color" class="block mt-1 w-full" type="color" name="bg_color"
                            wire:model="bg_color" />
                        <x-input-error :messages="$errors->get('bg_color')" for="bg_color" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="link" :value="__('Link')" />
                        <x-input id="link" class="block mt-1 w-full" type="text" name="link"
                            wire:model="link" />
                        <x-input-error :messages="$errors->get('link')" for="link" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="video" :value="__('Embeded Video')" />
                        <x-input id="embeded_video" class="block mt-1 w-full" type="text" name="embeded_video"
                            wire:model="embeded_video" />
                        <x-input-error :messages="$errors->get('embeded_video')" for="link" class="mt-2" />
                    </div>
                </div>

                <div class="w-full py-2 px-3">
                    <x-label for="description" :value="__('description')" />
                    <x-trix name="description" wire:model="description" class="mt-1" />
                    <x-input-error :messages="$errors->get('description')" for="description" class="mt-2" />
                </div>
                <div class="w-full py-2 px-3">
                    <x-media-upload title="{{ __('Image') }}" name="image" wire:model="image" :file="$image"
                        single types="PNG / JPEG / WEBP" fileTypes="image/*" />
                </div>
                <div class="text-center py-4">
                    <x-button primary type="submit" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
    <!-- End Create Modal -->
</div>
