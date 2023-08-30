<div>
    <!-- Edit Modal -->
    <x-modal wire:model.live="editModal">
        <x-slot name="title">
            {{ __('Edit Brand') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />
            <form wire:submit="update">

                <div class="w-full px-3 mb-4">
                    <x-label for="name" :value="__('Name')" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                        wire:model.blur="brand.name" />
                    <x-input-error :messages="$errors->get('brand.name')" for="name" class="mt-2" />
                </div>

                <div class="w-full px-3 mb-4">
                    <x-label for="description" :value="__('Description')" />
                    <textarea id="description" class="block mt-1 w-full" type="text" name="description"
                        wire:model.blur="brand.description"></textarea>
                    <x-input-error :messages="$errors->get('brand.description')" for="description" class="mt-2" />
                </div>

                <div class="w-full px-3 mb-4">
                    <x-label for="image" :value="__('Image')" />
                    <x-fileupload wire:model.live="image" :file="$image" accept="image/jpg,image/jpeg,image/png" />
                    <x-input-error :messages="$errors->get('image')" for="image" class="mt-2" />
                </div>

                <div class="w-full px-3">
                    <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
    <!-- End Edit Modal -->
</div>
