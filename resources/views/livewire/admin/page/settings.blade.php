<div>
    <x-card>
        <!-- Real-time Preview Section -->
        <div x-data="{ previewContent: '' }">
            <h3>Real-time Preview:</h3>
            <div x-html="previewContent"></div>
        </div>
        <div>
            <!-- List of sections -->
            <ul id="sections-list" x-sortable="sections" x-on:sort-end="updateSectionOrder">
                @foreach ($settings as $setting)
                    <li id="{{ $setting->id }}" class="border p-2 m-2 cursor-move bg-white shadow">
                        {{ $setting->section_order }} - {{ $setting->page->name ?? '' }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            <select wire:model="selectedTemplate">
                <option value="">Select a template</option>
                @foreach ($sectionTemplates as $template)
                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                @endforeach
            </select>
            <button x-on:click="applyTemplate">Apply Template</button>
        </div>

        <!-- Add or Edit Setting Form -->
        <form wire:submit.prevent="save" class="mb-4">
            <!-- Setting Fields -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="section_order"
                        class="block text-sm font-medium text-gray-700">{{ __('Section Order') }}</label>
                    <input type="number" wire:model="section_order" id="section_order"
                        class="mt-1 block w-full px-2 py-1 border border-gray-300 rounded-md">
                    @error('section_order')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="bg_color"
                        class="block text-sm font-medium text-gray-700">{{ __('Background Color') }}</label>
                    <div class="flex flex-col space-y-2 py-4">
                        <label for="colorScheme" class="block font-medium mb-2">Select a color :</label>
                        <div class="grid grid-cols-6 gap-4">
                            @foreach ($colors as $color)
                                <button type="button"
                                    class="w-6 h-6 rounded-full bg-{{ $color }}-500 cursor-pointer"
                                    wire:click="selectedColor('{{ $color }}')"></button>
                            @endforeach
                        </div>
                        <label for="colorScheme" class="block font-medium mb-2">Colors :</label>
                        <div class="grid grid-cols-6 gap-4">
                            @foreach ($colorOptions as $index => $color)
                                <div class="relative">
                                    <button
                                        class="w-6 h-6 rounded-full bg-{{ $selectedColor }}-{{ $color }} cursor-pointer"
                                        wire:click="selectBgColor({{ $color }})">
                                    </button>
                                    <span class="text-sm font-medium text-gray-500">{{ $color }}</span>
                                    {{-- <button class="absolute top-5 bg-white right-0 text-sm font-medium text-red-500"
                                            wire:click="removeColor({{ $index }})">X</button> --}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex items-center">
                    <label for="is_title" class="mr-3 block">{{ __('Enable Title') }}:</label>
                    <div
                        class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="is_title" id="is_title" wire:model="is_title"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                        <label for="is_title"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <label for="darkMode" class="mr-3 block">{{ __('Enable DarkMode') }}:</label>
                    <div
                        class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="darkMode" id="darkMode" wire:model="darkMode"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                        <label for="darkMode"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <label for="is_description" class="mr-3 block">{{ __('Enable Description') }}:</label>
                    <div
                        class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="is_description" id="is_description" wire:model="is_description"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                        <label for="is_description"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <label for="is_sliders" class="mr-3 block">{{ __('Enable slider') }}:</label>
                    <div
                        class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="is_sliders" id="is_sliders" wire:model="is_sliders"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                        <label for="is_sliders"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>

                <div class="mt-4 flex items-center">
                    <label for="is_contact" class="mr-3 block">{{ __('Enable contact form') }}:</label>

                    <div
                        class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="is_contact" id="is_contact" wire:model="is_contact"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                        <label for="is_contact"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>

                <div class="mt-4 flex items-center">
                    <label for="is_offer" class="mr-3 block">{{ __('Enable offer') }}:</label>
                    <div
                        class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="is_offer" id="is_offer" wire:model="is_offer"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                        <label for="is_offer"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>

                <div class="mt-4 flex items-center">
                    <label for="is_partners" class="mr-3 block">{{ __('Enable partners') }}:</label>
                    <div
                        class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="is_partners" id="is_partners" wire:model="is_partners"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                        <label for="is_partners"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <label for="is_package" class="mr-3 block">{{ __('Enable package') }}:</label>
                    <div
                        class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="is_package" id="is_package" wire:model="is_package"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                        <label for="is_package"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-4">
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                    Save
                </button>
                <button type="button" wire:click="resetForm"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
            </div>
        </form>

        <!-- Settings Table -->
        <div class="mb-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Section Order
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Page Name
                        </th>
                        <!-- Add more table headers for other properties -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($settings as $setting)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $setting->section_order }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $setting->page->name ?? '' }}
                            </td>
                            <!-- Add more table cells for other properties -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <x-button type="button" secondary wire:click="edit( { id : {{ $setting->id }} })"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </x-button>
                                <x-button type="button" danger wire:click="delete( { id : {{ $setting->id }} })"
                                    class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </x-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        {{ $settings->links() }}
    </x-card>

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', function() {
                function updateSectionOrder(event) {
                    let sections = [];
                    document.querySelectorAll('#sections-list > li').forEach((section, index) => {
                        sections.push({
                            id: section.id,
                            section_order: index + 1
                        });
                    });
                    @this.set('settings', sections);
                }
                Livewire.on('updatePreview', (content) => {
                    const preview = document.querySelector('[x-data="{ previewContent: \'\' }"]');
                    if (preview) {
                        preview.__x.$data.previewContent = content;
                    }
                });
            });
        </script>
    @endpush
</div>
