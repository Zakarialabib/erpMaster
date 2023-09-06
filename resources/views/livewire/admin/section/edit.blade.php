<div>
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit Section') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />

            <form enctype="multipart/form-data" wire:submit="update">
                <div class="flex flex-wrap space-y-2 px-2">
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="language_id" :value="__('Language')" />
                        <x-select-list :options="$this->languages"
                            class="block bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                            id="language_id" name="language_id" wire:model="language_id" />
                           
                        <x-input-error :messages="$errors->get('language_id')" for="language_id" class="mt-2" />
                    </div>

                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="page" :value="__('Page')" />
                        <select wire:model="page"
                            class="p-3 leading-5 bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500  lang"
                            name="page">
                            <option value="" selected>{{ __('Select a Page') }}</option>
                            <option value="1">{{ __('Home Page') }}</option>
                            <option value="2">{{ __('About Page') }}</option>
                            <option value="3">{{ __('Partner Page') }}</option>
                            <option value="4">{{ __('Blog Page') }}</option>
                            <option value="7">{{ __('Contact Page') }}</option>
                            <option value="8">{{ __('Products Page') }}</option>
                            <option value="9">{{ __('Privacy Page') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('page')" for="page" class="mt-2" />
                    </div>

                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="title" :value="__('Title')" />
                        <x-input type="text" name="title" wire:model.lazy="title" />
                        <x-input-error :messages="$errors->get('title')" for="title" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="subtitle" :value="__('Subtitle')" />
                        <x-input type="text" name="subtitle" wire:model.lazy="subtitle" />
                        <x-input-error :messages="$errors->get('subtitle')" for="subtitle" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="subtitle" :value="__('text color')" />
                        <input wire:model.lazy="text_color" id="text_color" type="color">
                        <x-input-error :messages="$errors->get('text_color')" for="text_color" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="subtitle" :value="__('background color')" />
                        <input wire:model.lazy="bg_color" id="bg_color" type="color">
                        <x-input-error :messages="$errors->get('bg_color')" for="bg_color" class="mt-2" />
                    </div>
                    <div class="w-1/3 px-2">
                        <x-label for="is_category" :value="__('is category')" />
                        <input wire:model.lazy="is_category" id="is_category" type="checkbox">
                        <x-input-error :messages="$errors->get('is_category')" for="is_category" class="mt-2" />
                    </div>
                    <div class="w-1/3 px-2">
                        <x-label for="is_product" :value="__('is product')" />
                        <input wire:model.lazy="is_product" id="is_product" type="checkbox">
                        <x-input-error :messages="$errors->get('is_product')" for="is_product" class="mt-2" />
                    </div>
                    <div class="w-full px-2">
                        <x-label for="description" :value="__('Description')" />
                        <x-trix wire:model="description" name="description" />
                        <x-input-error :messages="$errors->get('description')" for="description" class="mt-2" />
                    </div>
                    <div class="w-full px-2">
                        <x-label for="image" :value="__('Image')" />
                        <x-fileupload wire:model="image" :file="$image" accept="image/jpg,image/jpeg,image/png" />
                        <p class="help-block text-info">
                            {{ __('Upload 670X418 (Pixel) Size image for best quality. Only jpg, jpeg, png image is allowed.') }}
                        </p>
                        <x-input-error :messages="$errors->get('image')" for="image" class="mt-2" />
                    </div>
                    <div class="w-full px-3">
                        <x-button primary type="submit" wire:loading.attr="disabled" class="w-full">
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
