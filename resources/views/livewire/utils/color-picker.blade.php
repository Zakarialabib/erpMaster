<div>
    
    <x-label for="{{ $value }}" value="{{ $title }}" />
    <div class="grid grid-cols-6 gap-4 py-4">
        @foreach ($colors as $color)
            <button type="button" class="w-6 h-6 rounded-full bg-{{ $color }}-500 cursor-pointer"
                wire:click="showColorPalette('{{ $color }}')"></button>
        @endforeach
    </div>
    @if ($selectedColor)
        <label for="colorScheme" class="block font-medium mt-4 mb-2">
            Color Variations:</label>
        <div class="grid grid-cols-6 gap-4">
            @foreach ($colorOptions as $index => $colorOption)
                <div class="relative">
                    <button type="button"
                        class="w-6 h-6 rounded-full bg-{{ $selectedColor }}-{{ $colorOption }} cursor-pointer"
                        wire:click="selectColor('{{ $selectedColor }}-{{ $colorOption }}')">
                    </button>
                    <span class="text-sm font-medium text-gray-500">{{ $colorOption }}</span>
                </div>
            @endforeach
        </div>
        <!-- Selected Background Color Circle -->
        <div class="bg-{{ $value }} w-10 h-10 rounded-full mt-2">
        </div>
    @endif

</div>
