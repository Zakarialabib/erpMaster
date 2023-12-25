<div>
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit Category') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />
            <form wire:submit="update">
                <div class="space-y-4 px-4">

                    <div class="px-2 w-1/2 sm:w-full">
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                            wire:model="name" />
                        <x-input-error :messages="$errors->get('name')" for="name" class="mt-2" />
                    </div>
                    <div class="px-2 w-1/2 sm:w-full">
                        <x-label for="slug" :value="__('Slug')" />
                        <x-input id="slug" class="block mt-1 w-full" type="text" name="slug"
                            wire:model="slug" />
                        <x-input-error :messages="$errors->get('slug')" for="slug" class="mt-2" />
                    </div>

                    <div class="mt-4 px-2 w-1/2 sm:w-full">
                        <x-label for="category_id" :value="__('Category')" required />
                        <select
                            class="block bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                            id="category_id" name="category_id" wire:model="category_id">
                            <option value="">{{ __('Select Category') }}</option>
                            @foreach ($this->categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            <x-input-error :messages="$errors->get('category_id')" for="category_id" class="mt-2" />
                        </select>
                    </div>

                    <div class="mt-4 px-2 w-1/2 sm:w-full">
                        <x-label for="language_id" :value="__('Language')" required />
                        @if (settings('multi_language'))
                            <select
                                class="block bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                                id="language_id" name="language_id" wire:model="language_id">
                                @foreach ($languages as $id => $name)
                                    <option value="{{ $id }}"
                                        @if (Session::has('language') && Session::get('language') === $id) selected @endif>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <select
                                class="block bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                                id="language_id" name="language_id" wire:model="language_id">
                                <option value="{{ $languages['name'] }}" selected>{{ $languages['name'] }}</option>
                            </select>
                        @endif
                        <x-input-error :messages="$errors->get('language_id')" for="language_id" class="mt-2" />
                    </div>

                    <div class="w-full px-3">
                        <x-button primary type="submit" wire:loading.attr="disabled">
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
