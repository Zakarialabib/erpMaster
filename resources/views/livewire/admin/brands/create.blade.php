<div>
    <!-- Create Modal -->
    <x-modal wire:model="createModal">
        <x-slot name="title">
            {{ __('Create Brand') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />

            <form wire:submit="create">

                <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4 px-2">
                    <div>
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                            wire:model="name" />
                        <x-input-error :messages="$errors->get('name')" for="name" class="mt-2" />
                    </div>
               
                    <div>
                        <x-label for="meta_title" :value="__('Meta title')" />
                        <x-input id="meta_title" class="block mt-1 w-full" type="text" name="meta_title"
                            wire:model="meta_title" />
                        <x-input-error :messages="$errors->get('meta_title')" for="meta_title" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="meta_description" :value="__('Meta description')" />
                        <x-input id="meta_description" class="block mt-1 w-full" type="text" name="meta_description"
                            wire:model="meta_description" />
                        <x-input-error :messages="$errors->get('meta_description')" for="meta_description" class="mt-2" />
                    </div>
                </div>

                <div class="w-full px-2 mb-4">
                    <x-label for="description" :value="__('Description')" />
                    <textarea id="description" class="block mt-1 w-full" type="text" name="description" wire:model="description"></textarea>
                    <x-input-error :messages="$errors->get('description')" for="description" class="mt-2" />
                </div>
                <div class="w-full px-2 mb-4">
                    <x-label for="image" :value="__('Image')" />
                    <x-fileupload wire:model="image" :file="$image" accept="image/jpg,image/jpeg,image/png" />
                    <x-input-error :messages="$errors->get('image')" for="image" class="mt-2" />
                </div>
                <div class="w-full px-2 mb-4">
                    <x-label for=featured_image" :value="__('Featured image')" />
                    <x-fileupload wire:model=featured_image" :file="$featured_image"
                        accept="image/jpg,image/jpeg,image/png" />
                    <x-input-error :messages="$errors->get('featured_image')" for="featured_image" class="mt-2" />
                </div>
                <div class="w-full px-2">
                    <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
    <!-- End Create Modal -->
</div>
