<div>
    @section('title', __('Section Settings'))
    <x-card>
        <h1 class="text-2xl my-2 pb-4 font-bold">
            {{ __('Section Settings') }}
        </h1>
        <div class="flex flex-wrap">

            <aside class="w-full md:w-1/4 border-2 border-gray-100 h-screen overflow-y-scroll drop-shadow-lg ">
                <div class="w-full px-4">
                    <x-label for="section_id" :value="__('Select Section')" />
                    <select wire:model.live="section_id" name="section_id" required
                        class="p-2 leading-5 bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500 ">
                        <option value="" selected>{{ __('Select a Section') }}</option>
                        @foreach ($this->sections as $section)
                            <option value="{{ $section->id }}">
                                {{ $section->title }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('section_id')" for="section_id" class="mt-2" />
                </div>

                @if ($section_id)
                    @if ($sectionSetting)
                        <form wire:submit="save">
                            <div class="grid xl;grid-cols-2 sm-grid-cols-1 py-6 px-4 gap-4 w-full">
                                <div>
                                    <livewire:utils.color-picker wire:model="layout_config.item_style.background_color"
                                        :title="__('Select background color')" />
                                </div>
                                <div>
                                    <livewire:utils.color-picker wire:model="layout_config.item_style.text_color"
                                        :title="__('Select text color')" />
                                </div>
                                <div>
                                    <x-label for="section-font-size" :value="__('Font Size')" />
                                    <select wire:model.live="layout_config.item_style.font_size" id="section-font-size"
                                        name="section-font-size"
                                        class="p-2 leading-5 bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500 ">
                                        <option value="" selected>
                                            {{ __('Select a Font Size') }}
                                        </option>
                                        @foreach ($fontSizes as $fontSize)
                                            <option value="{{ $fontSize }}"
                                                @if ($layout_config['item_style']['font_size'] === $fontSize) selected @endif>
                                                {{ $fontSize }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-label for="section-width">
                                        {{ __('Column Width') }}
                                        {{ $layout_config['item_style']['width'] }}px
                                    </x-label>  
                                    <input wire:model.live="layout_config.item_style.width" type="range"
                                        id="section-width" name="section-width" min="1" max="100"
                                        class="w-full" />
                                </div>

                                <div>
                                    <x-label for="section-height">
                                        {{ __('Column height') }}
                                        {{ $layout_config['item_style']['height'] }}px
                                    </x-label>
                                    <input wire:model.live="layout_config.item_style.height" type="range"
                                        id="section-height" name="section-height" min="1" max="100"
                                        class="w-full" />
                                </div>

                                <div x-data="{ customPadding: false }">
                                    <div x-show="!customPadding">
                                        <x-label for="section-padding">
                                            {{ __('Padding (px)') }} {{ $layout_config['item_style']['padding'] }}px
                                        </x-label>
                                        <input wire:model.live="layout_config.item_style.padding" type="range"
                                            id="section-padding" name="section-padding" min="0" max="100"
                                            class="w-full" />

                                    </div>

                                    <input type="checkbox" x-on:click="customPadding = !customPadding"
                                        id="custom-padding">
                                    <label class="text-gray-600 text-sm" for="custom-padding">Custom Padding</label>

                                    <div x-show="customPadding" class="grid grid-cols-2 gap-4 py-4">
                                        <div>
                                            <x-label for="padding-top" :value="__('Padding Top (px)')" />
                                            <input wire:model="layout_config.item_style.padding.top" type="number"
                                                id="padding-top" name="padding-top" class="w-full">
                                        </div>
                                        <div>
                                            <x-label for="padding-bottom" :value="__('Padding Bottom (px)')" />
                                            <input wire:model="layout_config.item_style.padding.bottom" type="number"
                                                id="padding-bottom" name="padding-bottom" class="w-full">
                                        </div>
                                        <div>
                                            <x-label for="padding-left" :value="__('Padding Left (px)')" />
                                            <input wire:model="layout_config.item_style.padding.left" type="number"
                                                id="padding-left" name="padding-left" class="w-full">
                                        </div>
                                        <div>
                                            <x-label for="padding-right" :value="__('Padding Right (px)')" />
                                            <input wire:model="layout_config.item_style.padding.right" type="number"
                                                id="padding-right" name="padding-right" class="w-full">
                                        </div>
                                    </div>
                                </div>
                                <div x-data="{ customMargin: false }">
                                    <div x-show="!customMargin">
                                        <x-label for="section-margin">
                                            {{ __('Margin (px)') }}
                                            {{ $layout_config['item_style']['margin'] }}px
                                        </x-label>
                                        <input wire:model.live="layout_config.item_style.margin" type="range"
                                            id="section-margin" name="section-margin" min="0" max="100"
                                            class="w-full" />
                                    </div>

                                    <input type="checkbox" x-on:click="customMargin = !customMargin" id="custom-margin">
                                    <label class="text-gray-600 text-sm" for="custom-margin">Custom Margin</label>

                                    <div x-show="customMargin" class="grid grid-cols-2 gap-4 py-4">
                                        <div>
                                            <x-label for="margin-top" :value="__('Margin Top (px)')" />
                                            <input wire:model="layout_config.item_style.margin.top" type="number"
                                                id="margin-top" name="margin-top" class="w-full">
                                        </div>
                                        <div>
                                            <x-label for="margin-bottom" :value="__('Margin Bottom (px)')" />
                                            <input wire:model="layout_config.item_style.margin.bottom" type="number"
                                                id="margin-bottom" name="margin-bottom" class="w-full">
                                        </div>
                                        <div>
                                            <x-label for="margin-left" :value="__('Margin Left (px)')" />
                                            <input wire:model="layout_config.item_style.margin.left" type="number"
                                                id="margin-left" name="margin-left" class="w-full">
                                        </div>
                                        <div>
                                            <x-label for="margin-right" :value="__('Margin Right (px)')" />
                                            <input wire:model="layout_config.item_style.margin.right" type="number"
                                                id="margin-right" name="margin-right" class="w-full">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <x-label for="section-border-width">
                                        {{ __('Border Width') }}
                                        {{ $layout_config['item_style']['border']['width'] }}px
                                    </x-label>
                                    <input wire:model.live="layout_config.item_style.border.width" type="range"
                                        min="0" max="100" class="w-full" name="border_width" />
                                </div>
                                <div>
                                    <x-label for="section-border-color" :value="__('Border Color')" />
                                    <input wire:model.live="layout_config.item_style.border.color" type="color"
                                        name="border_color" />
                                </div>
                                <div>
                                    <x-label for="section-border-style" :value="__('Border Style')" />
                                    <select
                                        class="p-3 leading-5 bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500 "
                                        wire:model.live="layout_config.item_style.border.style" name="border_style">
                                        <option value="">
                                            {{ __('Select a border style') }}
                                        </option>
                                        <option value="solid">Solid
                                        </option>
                                        <option value="dashed">Dashed
                                        </option>
                                        <option value="dotted">Dotted
                                        </option>
                                        <option value="double">Double
                                        </option>
                                        <option value="groove">Groove
                                        </option>
                                        <option value="ridge">Ridge
                                        </option>
                                        <option value="inset">Inset
                                        </option>
                                        <option value="outset">Outset
                                        </option>
                                        <option value="none">None
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <x-label for="section-border-radius" :value="__('Border Radius')" />
                                    <input wire:model.live="layout_config.item_style.border.radius" type="range"
                                        min="0" max="100" class="w-full" name="border_radius" />
                                </div>

                                <div>
                                    <x-label for="section-box-shadow" :value="__('Box Shadow')" />
                                    <input wire:model.live="layout_config.item_style.box_shadow" type="number"
                                        name="box_shadow" />
                                </div>
                            </div>
                            <x-button type="submit" primary wire:loading.attr="disabled" wire:target="save"
                                class="w-full">
                                {{ __('save') }}
                            </x-button>
                        </form>
                    @else
                        <form wire:submit="save">
                            <div class="w-full px-4 grid grid-cols-2 gap-4">

                                <div class="col-span-full">
                                    <x-label for="selectedTemplate" :value="__('Select Templates')" />
                                    <select wire:model.live="selectedTemplate" name="selectTemplate" required
                                        class="p-2 leading-5 bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500 ">
                                        <option value="" selected>
                                            {{ __('Select a Section') }}</option>
                                        @foreach ($this->templates as $index => $template)
                                            <option value="{{ $index }}">
                                                {{ $template['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('section_id')" for="section_id" class="mt-2" />
                                </div>

                                <div>
                                    <x-label for="create_layout_type" :value="__('Page Layout Type')" />
                                    <select wire:model.live="layout_type" name="create_layout_type"
                                        id="create_layout_type"
                                        class="p-2 leading-5 bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500 ">
                                        <option value="">
                                            {{ __('Select Layout Type') }}
                                        </option>
                                        @foreach ($layoutTypes as $layoutType)
                                            <option value="{{ $layoutType }}">
                                                {{ $layoutType }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <x-label for="create_sizing" :value="__('Section Sizing')" />
                                    <select wire:model.live="sizing" name="create_sizing" id="create_sizing"
                                        class="p-2 leading-5 bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500">
                                        <option value="35">33%</option>
                                        <option value="50">50%</option>
                                        <option value="75">75%</option>
                                        <option value="100">Full/100%</option>
                                    </select>

                                </div>
                                <div>
                                    <livewire:utils.color-picker wire:model="bg_color" :title="__('Select background color')" />
                                </div>
                            </div>

                            <div class="mt-4 w-full px-4">
                                <x-button type="submit" wire:loading.attr="disabled" primary
                                    class="w-full flex justify-center" wire:target="save">
                                    {{ __('Save') }}
                                </x-button>
                            </div>
                        </form>
                    @endif
                @endif
            </aside>

            <div class="w-full md:w-3/4 h-screen px-4">
                @if ($section_id)
                    <div class="text-{{ $layout_config['item_style']['font_size'] ?? 'sm' }} 
                            bg-{{ $layout_config['item_style']['background_color'] ?? 'transparent' }} 
                            text-{{ $layout_config['item_style']['text_color'] ?? 'black' }}"
                        style="width: {{ $layout_config['item_style']['width'] ?? '100%' }}%;
                            height: {{ $layout_config['item_style']['height'] ?? 'auto' }}%;
                            padding: {{ $layout_config['item_style']['padding'] ?? '' }}px;
                            margin: {{ $layout_config['item_style']['margin'] ?? '' }}px;
                            border: {{ $layout_config['item_style']['border']['width'] ?? '' }}px {{ $layout_config['item_style']['border']['style'] ?? '' }} {{ $layout_config['item_style']['border']['color'] ?? '' }};
                            border-radius: {{ $layout_config['item_style']['border_radius'] ?? '' }}px;
                            box-shadow: {{ $layout_config['item_style']['box_shadow'] ?? '' }};">
                        <div class="border-b text-center">
                            @isset($layout_config['item_config']['paralax'])
                                <div class="bg-quote py-10 flex items-center justify-center h-[300px] mx-auto"
                                    style="background: url({{ asset('images/sections/' . $section->image) }}) center center no-repeat; background-attachment: fixed;">
                                    <div class="mb-4 font-bold font-heading">
                                        {{ $section->title }}
                                    </div>
                                </div>
                            @else
                                <h3
                                    class="mb-4 text-text-{{ $layout_config['item_style']['font_size'] ?? 'sm' }}  font-bold font-heading">
                                    {{ $section->title }}
                                </h3>
                            @endisset
                            @if ($section->subtitle)
                                <p>{{ $section->subtitle }}</p>
                            @endif
                        </div>
                        <div class="py-5 px-4 text-center">
                            <p class="text-lg text-gray-500">
                                {!! $section->description !!}
                            </p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6">
                        {{ __('Select a section to edit') }}
                    </div>
                @endif
            </div>
        </div>
    </x-card>
</div>
