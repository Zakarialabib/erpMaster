<div>
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit Device model') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />
            <form wire:submit.prevent="update">
                <div class="flex flex-wrap space-y-2 px-2">
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                            wire:model.lazy="device_model.name" />
                        <x-input-error :messages="$errors->get('device_model.name')" for="device_model.name" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="slug" :value="__('Slug')" />
                        <x-input id="slug" class="block mt-1 w-full" type="text" name="slug"
                            wire:model.lazy="device_model.slug" />
                        <x-input-error :messages="$errors->get('device_model.slug')" for="device_model.slug" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="code" :value="__('Code')" />
                        <x-input id="code" class="block mt-1 w-full" type="text" name="code"
                            wire:model.lazy="device_model.code" />
                        <x-input-error :messages="$errors->get('device_model.code')" for="device_model.code" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="type" :value="__('Type')" />
                        <select id="type" class="block mt-1 w-full" name="type"
                            wire:model.lazy="device_model.type">
                            @foreach (\App\Enums\DeviceModelType::getSelectOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('device_model.type')" for="device_model.type" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2 sm:w-full px-2">
                        <x-label for="brand_id" :value="__('Brand')" />
                        <select id="brand_id" class="block mt-1 w-full" name="brand_id"
                            wire:model.lazy="device_model.brand_id">
                            @foreach (\App\Helpers::getBrands() as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('device_model.brand_id')" for="device_model.brand_id" class="mt-2" />
                    </div>
                    <div class="w-full px-2">
                        <x-label for="description" :value="__('Description')" />
                        <x-trix name="description" wire:model.lazy="description" />
                    </div>

                    <div class="w-full px-2">
                        <x-label for="technical_details" :value="__('Technical Details')" />
                        <x-trix name="technical_details" wire:model.lazy="technical_details" />
                    </div>

                    <div class="w-full px-2">
                        <x-label for="features" :value="__('Features')" />
                        <x-trix name="features" wire:model.lazy="features" />
                    </div>

                    <div class="w-full px-2">
                        <x-label for="specifications" :value="__('Specifications')" />
                        <x-trix name="specifications" wire:model.lazy="specifications" />
                    </div>



                    <div class="w-full px-2">
                        <x-label for="image" :value="__('Device model Logo')" />
                        <x-media-upload title="{{ __('Device model Logo') }}" name="image" wire:model="image"
                            :file="$image" single types="PNG / JPEG / WEBP" fileTypes="image/*" />
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
</div>
