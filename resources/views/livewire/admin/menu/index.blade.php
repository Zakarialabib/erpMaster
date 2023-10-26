<div>
    @section('title', __('Menu Settings'))

    <x-theme.breadcrumb :title="__('Menu')" :parent="route('admin.menu-settings.index')" :parentName="__('Menu')">
    </x-theme.breadcrumb>


    <div class="flex flex-wrap">
        <div class="w-1/4 p-4 ">
            {{-- <x-button type="button" wire:click="predefinedMenu" primary class="w-full flex justify-center"
                    wire:loading.attr="disabled">
                    {{ __('Add Predefined Menu') }}
                </x-button> --}}
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />
            <x-theme.accordion title="Add Menu">
                <form wire:submit="store" class="grid grid-cols gap-2 px-4">
                    <div class="w-full">
                        <x-label for="name" :value="__('Name')" required />
                        <x-input id="menuName" class="block mt-1 w-full" required type="text" name="MenuName"
                            wire:model="name" />
                        <x-input-error :messages="$errors->get('name')" for="name" class="mt-2" />
                    </div>
                    <div class="w-full">
                        <x-label for="type" :value="__('Type')" required />
                        <select id="menuType" required
                            class="border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 block w-full sm:text-sm rounded-md mt-1"
                            name="type" wire:model="type">
                            <option value="">{{ __('Select Type') }}</option>
                            @foreach (\App\Enums\MenuType::values() as $key => $value)
                                <option value="{{ $key }}" @if ($type === $value) selected @endif>
                                    {{ __($value) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('type')" for="type" class="mt-2" />
                    </div>
                    <div class="w-full">
                        <x-label for="placement" :value="__('Placement')" required />
                        <select id="menuPlacement" required
                            class="border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 block w-full sm:text-sm rounded-md mt-1"
                            name="menuPlacement" wire:model="placement">
                            <option value="">{{ __('Select Placement') }}</option>
                            @foreach (\App\Enums\MenuPlacement::values() as $key => $value)
                                <option value="{{ $key }}" @if ($placement === $value) selected @endif>
                                    {{ __($value) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('placement')" for="placement" class="mt-2" />
                    </div>
                    <div class="w-full">
                        <x-label for="label" :value="__('Label')" required />
                        <x-input id="menuLabel" class="block mt-1 w-full" type="text" name="menuLabel" required
                            wire:model="label" />
                        <x-input-error :messages="$errors->get('label')" for="label" class="mt-2" />
                    </div>

                    <div class="w-full">
                        <x-label for="url" :value="__('URL')" required />
                        <x-input id="menuUrl" class="block mt-1 w-full" type="text" name="menuUrl" required
                            wire:model="url" />
                        <x-input-error :messages="$errors->get('url')" for="url" class="mt-2" />
                    </div>

                    <div class="w-full">
                        <x-label for="parent_id" :value="__('Parent ID')" />
                        <select id="parent_id"
                            class="border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 block w-full sm:text-sm rounded-md mt-1"
                            name="parent_id" wire:model="parent_id">
                            <option></option>
                            @foreach ($this->menus as $menuItem)
                                <option value="{{ $menuItem['id'] }}">{{ $menuItem['name'] }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('parent_id')" for="parent_id" class="mt-2" />
                    </div>

                    <div class="w-full">
                        <x-label for="new_window" :value="__('New Window')" />
                        <label class="flex items-center mt-2">
                            <input id="new_window" name="new_window" type="checkbox" class="form-checkbox"
                                wire:model="new_window">
                            <span class="ml-2">{{ __('New Window') }}</span>
                        </label>
                        <x-input-error :messages="$errors->get('new_window')" for="new_window" class="mt-2" />
                    </div>


                    <div class="w-full py-4">
                        <x-button primary type="submit" wire:loading.attr="disabled" class="w-full">
                            {{ __('Create') }}
                        </x-button>
                    </div>
                </form>
            </x-theme.accordion>
            <x-theme.accordion title="Clone Menu">
                <form wire:submit="clone" class="grid grid-cols gap-2 px-4">

                    <div class="w-full">
                        <x-label for="selectedMenu" :value="__('Menus')" required />
                        <select id="selectedMenu" required name="selectedMenu" wire:model="selectedMenu"
                            class="border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 block w-full sm:text-sm rounded-md mt-1">
                            <option>{{ __('Select menu') }}</option>
                            @foreach ($menus as $index => $menu)
                                <option value="{{ $menu['id'] }}">
                                    {{ $menu['name'] }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('selectedMenu')" for="selectedMenu" class="mt-2" />
                    </div>

                    <div class="w-full">
                        <x-label for="placement" :value="__('Placement')" required />
                        <select id="menuPlacement" required name="menuPlacement" wire:model="placement"
                            class="border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 block w-full sm:text-sm rounded-md mt-1">
                            <option value="">{{ __('Select Placement') }}</option>
                            @foreach (\App\Enums\MenuPlacement::values() as $key => $value)
                                <option value="{{ $key }}" @if ($placement === $value) selected @endif>
                                    {{ __($value) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('placement')" for="placement" class="mt-2" />
                    </div>

                    <div class="w-full py-4">
                        <x-button primary type="submit" wire:loading.attr="disabled" class="w-full">
                            {{ __('Clone') }}
                        </x-button>
                    </div>
                </form>
            </x-theme.accordion>
        </div>
        <div class="w-3/4 p-4" x-data="{ sortable: null }" x-init="sortable = new Sortable($refs.menuList, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function(e) {
                const items = Array.from(e.to.children);
                const ids = items.map(item => item.dataset.id);
                @this.updateMenuOrder(ids);
            }
        })">
            <div class="flex flex-wrap justify-center gap-4 mb-4">
                @foreach (\App\Enums\MenuPlacement::values() as $key => $value)
                    <x-button type="button" wire:click="filterByPlacement('{{ $key }}')" :class="$placement === $key
                        ? 'bg-blue-500 text-white'
                        : 'bg-transparent text-blue-500 border border-blue-500'"
                        outline>
                        {{ __($key) }}
                    </x-button>
                @endforeach
                <x-button type="button" wire:click="filterByPlacement('')" danger-outline>
                    <i class="fas fa-times"></i>
                </x-button>
            </div>
            <div class="border border-gray-200 rounded-md shadow-sm mb-2 p-2 w-full" x-ref="menuList">
                @forelse($menus as $index => $menu)
                    <div class="border border-gray-300 rounded-md shadow-sm mb-2 p-2 w-full"
                        wire:loading.class.delay="opacity-50" wire:key="menu-{{ $index }}"
                        data-id="{{ $menu['id'] }}" x-data="{ isMenuOpen: false }">
                        <div class="flex justify-between ">
                            <div class="flex gap-4">
                                <div class="drag-handle cursor-move">
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                </div>
                                <button @click="isMenuOpen = !isMenuOpen">
                                    <i class="fa fa-caret-down"
                                        :class="{
                                            'fa-caret-up': isMenuOpen,
                                            'fa-caret-down': !isMenuOpen
                                        }"
                                        aria-hidden="true">
                                    </i>
                                </button>
                            </div>
                            <button @click="isMenuOpen = !isMenuOpen">
                                <h3 class="text-center">{{ $menu['name'] }}</h3>
                            </button>
                            <button type="button" class="text-red-500 px-2"
                                wire:click="delete({{ $menu['id'] }})" danger><i
                                    class="fas fa-trash-alt"></i></button>
                        </div>

                        <div x-show="isMenuOpen"
                            x-transition:enter="transition ease-out duration-300 transform origin-top"
                            x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-200 opacity-0 transform origin-top"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="-translate-y-4 scale-95">
                            <form wire:submit="update({{ $menu['id'] }})">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="w-full">
                                        <x-label for="name" :value="__('Name')" required />
                                        <x-input id="name{{ $index }}" class="block mt-1 w-full" required
                                            type="text" name="name"
                                            wire:model="menus.{{ $index }}.name" />
                                        <x-input-error :messages="$errors->get('menu.name')" for="name" class="mt-2" />
                                    </div>
                                    <div class="w-full">
                                        <x-label for="type" :value="__('Type')" required />
                                        <select id="type{{ $index }}" required
                                            class="border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 block w-full sm:text-sm rounded-md mt-1"
                                            name="type" wire:model="menus.{{ $index }}.type">
                                            <option value="">{{ __('Select Type') }}</option>
                                            @foreach (\App\Enums\MenuType::values() as $key => $value)
                                                <option value="{{ $key }}"
                                                    @if ($menu['type'] === $value) selected @endif>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('menu.type')" for="type" class="mt-2" />
                                    </div>
                                    <div class="w-full">
                                        <x-label for="placement" :value="__('Placement')" required />
                                        <select id="placement{{ $index }}" required
                                            class="border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 block w-full sm:text-sm rounded-md mt-1"
                                            name="placement" wire:model="menus.{{ $index }}.placement">
                                            <option value="">{{ __('Select Placement') }}</option>
                                            @foreach (\App\Enums\MenuPlacement::values() as $key => $value)
                                                <option value="{{ $key }}"
                                                    @if ($menu['placement'] === $value) selected @endif>
                                                    {{ __($value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('menu.placement')" for="placement" class="mt-2" />
                                    </div>

                                    <div class="w-full">
                                        <x-label for="label" :value="__('Label')" required />
                                        <x-input id="label{{ $index }}" class="block mt-1 w-full" required
                                            type="text" name="label"
                                            wire:model="menus.{{ $index }}.label" />
                                        <x-input-error :messages="$errors->get('menu.label')" for="label" class="mt-2" />
                                    </div>

                                    <div class="relative w-full" x-data="{ isOpenLinks: false }">
                                        <x-label for="label{{ $index }}" :value="__('URL')" required />
                                        <div class="relative">
                                            <x-input id="label{{ $index }}" class="block mt-1 w-full" required
                                                type="text" name="label{{ $index }}" x-ref="url"
                                                wire:model="menus.{{ $index }}.url" />
                                            <div
                                                class="absolute right-0 top-0 h-full w-8 flex items-center justify-center">
                                                <button x-on:click="isOpenLinks = !isOpenLinks" type="button"
                                                    class="text-gray-500 focus:outline-none">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div x-show="isOpenLinks"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 transform scale-95"
                                            x-transition:enter-end="opacity-100 transform scale-100"
                                            x-transition:leave="transition ease-in duration-300"
                                            x-transition:leave-start="opacity-100 transform scale-100"
                                            x-transition:leave-end="opacity-0 transform scale-95"
                                            @click.away="isOpenLinks = false"
                                            class="absolute w-full mt-2 bg-white shadow-lg rounded-md overflow-y-auto max-h-60 z-10">
                                            <ul>
                                                @foreach ($links as $key => $link)
                                                    <li>
                                                        <button
                                                            x-on:click="isOpenLinks = false; $refs.url.focus(); $refs.url.value = '{{ $link['slug'] }}';
                                                                $wire.set('menus.{{ $index }}.url', '{{ $link['slug'] }}')"
                                                            {{-- menus.{{ $index }}.url --}} type="button"
                                                            class="w-full px-4 py-2 hover:bg-gray-100 text-left">
                                                            {{ $link['slug'] }}
                                                        </button>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <x-input-error :messages="$errors->get('menu.url')" for="url" class="mt-2" />
                                    </div>

                                    <div class="w-full">
                                        <x-label for="parent_id" :value="__('Parent ID')" />
                                        <select id="parent_id{{ $index }}"
                                            class="border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 block w-full sm:text-sm rounded-md mt-1"
                                            name="parent_id" wire:model="menus.{{ $index }}.parent_id">
                                            <option></option>
                                            @foreach ($this->menus as $menuItem)
                                                <option value="{{ $menuItem['id'] }}"
                                                    @if ($menuItem['parent_id'] == $menuItem['id']) selected @endif>
                                                    {{ $menuItem['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('menu.parent_id')" for="parent_id" class="mt-2" />
                                    </div>

                                    <div class="w-full">
                                        <x-label for="new_window" :value="__('New Window')" />
                                        <label class="flex items-center mt-2">
                                            <input id="new_window{{ $index }}" name="new_window"
                                                type="checkbox" class="form-checkbox" wire:model="new_window">
                                            <span class="ml-2">{{ __('New Window') }}</span>
                                        </label>
                                        <x-input-error :messages="$errors->get('menu.new_window')" for="new_window" class="mt-2" />
                                    </div>
                                    <p class="float-right">
                                        <x-button type="button"
                                            wire:click="update({{ $menu['id'] }}, {{ $index }})"
                                            wire:target="update({{ $menu['id'] }})" primary
                                            wire:loading.attr="disabled">
                                            {{ __('Edit') }}
                                        </x-button>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center">{{ __('No menus found') }}.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
