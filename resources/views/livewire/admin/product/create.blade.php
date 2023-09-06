<div>
    <!-- Create Modal -->
    <x-modal wire:model="createModal">
        <x-slot name="title">
            {{ __('Create Product') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="create">
                <x-validation-errors class="mb-4" :errors="$errors" />
                <div>
                    <div class="flex flex-wrap -mx-2 mb-3">
                   

                        <div class="w-full px-4 my-2">
                            <x-label for="image" :value="__('Product Image')" />
                            <x-media-upload title="{{ __('Product Image') }}" name="image" wire:model="image"
                                :file="$image" single types="PNG / JPEG / WEBP" fileTypes="image/*" />
                        </div>

                        <div class="w-full px-4 my-2">
                            <x-label for="gallery" :value="__('Gallery')" />
                            <x-media-upload title="{{ __('Gallery') }}" name="gallery" wire:model="gallery"
                                :file="$gallery" multiple types="PNG / JPEG / WEBP" fileTypes="image/*" />
                        </div>

                    </div>

                    <x-accordion title="{{ __('More Details') }}">
                        <div class="flex flex-wrap px-4 mb-3">

                            <div class="w-full px-2">
                                <livewire:admin.product.product-options />
                            </div>

                            <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="meta_title" :value="__('Meta Title')" />
                                <x-input id="meta_title" class="block mt-1 w-full" type="number" name="meta_title"
                                    wire:model="product.meta_title" />
                                <x-input-error :messages="$errors->get('meta_title')" for="meta_title" class="mt-2" />
                            </div>

                            <div class="lg:w-1/3 sm:w-1/2 px-2">
                                <x-label for="meta_description" :value="__('Meta Description')" />
                                <x-input id="meta_description" class="block mt-1 w-full" type="number"
                                    name="meta_description" wire:model="product.meta_description" />
                                <x-input-error :messages="$errors->get('meta_description')" for="meta_description" class="mt-2" />
                            </div>

                          
                        </div>
                    </x-accordion>

                    <div class="w-full px-4">
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
